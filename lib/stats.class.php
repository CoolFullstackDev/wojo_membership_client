<?php
  /**
   * Stats Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: stats.class.php, v1.00 2016-04-20 18:20:24 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class Stats
  {


      /**
       * Stats::__construct()
       * 
       * @return
       */
      public function __construct()
      {

      }
	  
      /**
       * Stats::exportUsers()
       * 
       * @return
       */
      public static function exportUsers()
      {
          $sql = "
		  SELECT 
			CONCAT(fname, ' ', lname) AS name,
			u.membership_id,
			u.mem_expire,
			u.email,
			u.newsletter,
			u.created,
			m.title AS mtitle
		  FROM
			`" . Users::mTable . "` AS u 
			LEFT JOIN " . Membership::mTable . " AS m 
			  ON m.id = u.membership_id 
		  WHERE (
			  TYPE = 'staff' || TYPE = 'editor' || TYPE = 'member'
			) 
		  ORDER BY u.fname;";
		  
		  $rows = Db::run()->pdoQuery($sql)->results();
		  
          $result = array();
          if (is_array($rows)) {
              foreach ($rows as $i => $val) {
                  $result[$i]['name'] = $val->name;
				  $result[$i]['membership'] = $val->membership_id ? $val->mtitle : '-/-';
				  $result[$i]['mem_expire'] = $val->membership_id ? Date::doDate("long_date", $val->mem_expire) : '-/-';
				  $result[$i]['email'] = $val->email;
				  $result[$i]['newsletter'] = $val->newsletter ? Lang::$word->YES : Lang::$word->NO;
				  $result[$i]['created'] = $val->created;
              }
          }
		  
          return $result;

      }
	  
      /**
       * Stats::userHistory()
       * 
       * @return
       */
      public static function userHistory($id, $order = 'activated')
      {
          $sql = "
		  SELECT 
			um.activated,
			um.mid,
			um.tid,
			um.expire,
			um.recurring,
			m.title,
			m.price
		  FROM
			`" . Membership::umTable . "` AS um 
			LEFT JOIN " . Membership::mTable . " AS m 
			  ON m.id = um.mid 
		  WHERE um.uid = ?
		  ORDER BY um.$order DESC;";
		  
		  $row = Db::run()->pdoQuery($sql, array($id))->results();
		  
          return $row ? $row : 0;

      }

      /**
       * Stats::userTotals()
       * 
       * @return
       */
      public static function userTotals()
      {
          $sql = "
		  SELECT 
		    SUM(total) as total
		  FROM
			`" . Membership::pTable . "`
		  WHERE user_id = ?
		  GROUP BY user_id;";
		  
		  $row = Db::run()->pdoQuery($sql, array(App::Auth()->uid))->result();
		  
          return $row ? $row->total : 0;

      }
	  
      /**
       * Stats::userPayments()
       * 
       * @return
       */
      public static function userPayments($id)
      {
          $sql = "
		  SELECT 
		    p.txn_id,
		    m.title,
			p.rate_amount,
			p.tax,
			p.coupon,
			p.total,
			p.created,
			p.status,
			p.membership_id
		  FROM
			`" . Membership::pTable . "` AS p 
			LEFT JOIN " . Membership::mTable . " AS m 
			  ON m.id = p.membership_id 
		  WHERE p.user_id =?
		  ORDER BY p.created DESC;";
		  
		  $row = Db::run()->pdoQuery($sql, array($id))->results();
		  
          return $row ? $row : 0;

      }
	  
      /**
       * Stats::exportUserPayments()
       * 
       * @return
       */
      public static function exportUserPayments($id)
      {
          $sql = "
		  SELECT 
		    p.txn_id,
		    m.title,
			p.rate_amount,
			p.tax,
			p.coupon,
			p.total,
			p.currency,
			p.pp,
			p.created
		  FROM
			`" . Membership::pTable . "` AS p 
			LEFT JOIN " . Membership::mTable . " AS m 
			  ON m.id = p.membership_id 
		  WHERE p.user_id =?
		  ORDER BY p.created DESC;";
		  
		  $rows = Db::run()->pdoQuery($sql, array($id))->results();
		  $array = json_decode(json_encode($rows), true);
		  
          return $array ? $array : 0;

      }
	  
      /**
       * Stats::getUserPaymentsChart()
       * 
       * @return
       */
      public static function getUserPaymentsChart($id)
      {

          $data = array();
          $data['label'] = array();
          $data['color'] = array();
          $data['legend'] = array();
		  $data['preUnits'] = Utility::currencySymbol(); 

          $color = array(
              "#03a9f4",
              "#33BFC1",
              "#ff9800",
              "#e91e63",
              );

          $labels = array(
              Lang::$word->TRX_SALES,
              Lang::$word->TRX_AMOUNT,
              Lang::$word->TRX_TAX,
              Lang::$word->TRX_COUPON,
			  );

		  for ($i = 1; $i <= 12; $i++) {
			  $data['data'][$i]['m'] = Date::dodate("MMM", date("F", mktime(0, 0, 0, $i, 10)));
			  $reg_data[$i] = array(
				  'month' => date('M', mktime(0, 0, 0, $i)),
				  'sales' => 0,
				  'amount' => 0,
				  'tax' => 0,
				  'coupon' => 0);
		  }

		  $sql = ("
			SELECT 
			  COUNT(id) AS sales,
			  SUM(rate_amount) AS amount,
			  SUM(tax) AS tax,
			  SUM(coupon) AS coupon,
			  MONTH(created) as created 
			FROM
			  `" . Membership::pTable . "` 
			  WHERE user_id = ?
			GROUP BY MONTH(created);
		  ");
		  $query = Db::run()->pdoQuery($sql, array($id));

		  foreach ($query->results() as $result) {
			  $reg_data[$result->created] = array(
				  'month' => Date::dodate("MMM", date("F", mktime(0, 0, 0, $result->created, 10))),
				  'sales' => $result->sales,
				  'amount' => $result->amount,
				  'tax' => $result->tax,
				  'coupon' => $result->coupon
				  );
		  }


          foreach ($reg_data as $key => $value) {
              $data['data'][$key][Lang::$word->TRX_SALES] = $value['sales'];
              $data['data'][$key][Lang::$word->TRX_AMOUNT] = $value['amount'];
              $data['data'][$key][Lang::$word->TRX_TAX] = $value['tax'];
              $data['data'][$key][Lang::$word->TRX_COUPON] = $value['coupon'];
          }

          foreach ($labels as $k => $label) {
              $data['label'][] = $label;
              $data['color'][] = $color[$k];
              $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[$k] . '"> </span> ' . $label . '</div>';
          }
          $data['data'] = array_values($data['data']);
          return $data;
      }

      /**
       * Stats::getMembershipPaymentsChart()
       * 
       * @return
       */
      public static function getMembershipPaymentsChart($id)
      {

          $data = array();
          $data['label'] = array();
          $data['color'] = array();
          $data['legend'] = array();
		  $data['preUnits'] = Utility::currencySymbol(); 

          $color = array(
              "#03a9f4",
              "#33BFC1",
              "#ff9800",
              "#e91e63",
              );

          $labels = array(
              Lang::$word->TRX_SALES,
              Lang::$word->TRX_AMOUNT,
              Lang::$word->TRX_TAX,
              Lang::$word->TRX_COUPON,
			  );

		  for ($i = 1; $i <= 12; $i++) {
			  $data['data'][$i]['m'] = Date::dodate("MMM", date("F", mktime(0, 0, 0, $i, 10)));
			  $reg_data[$i] = array(
				  'month' => date('M', mktime(0, 0, 0, $i)),
				  'sales' => 0,
				  'amount' => 0,
				  'tax' => 0,
				  'coupon' => 0);
		  }

		  $sql = ("
			SELECT 
			  COUNT(id) AS sales,
			  SUM(rate_amount) AS amount,
			  SUM(tax) AS tax,
			  SUM(coupon) AS coupon,
			  MONTH(created) as created
			FROM
			  `" . Membership::pTable . "` 
			  WHERE membership_id = ?
			  AND status = ?
			GROUP BY MONTH(created);
		  ");
		  $query = Db::run()->pdoQuery($sql, array($id, 1));

		  foreach ($query->results() as $result) {
			  $reg_data[$result->created] = array(
				  'month' => Date::dodate("MMM", date("F", mktime(0, 0, 0, $result->created, 10))),
				  'sales' => $result->sales,
				  'amount' => $result->amount,
				  'tax' => $result->tax,
				  'coupon' => $result->coupon
				  );
		  }


          foreach ($reg_data as $key => $value) {
              $data['data'][$key][Lang::$word->TRX_SALES] = $value['sales'];
              $data['data'][$key][Lang::$word->TRX_AMOUNT] = $value['amount'];
              $data['data'][$key][Lang::$word->TRX_TAX] = $value['tax'];
              $data['data'][$key][Lang::$word->TRX_COUPON] = $value['coupon'];
          }

          foreach ($labels as $k => $label) {
              $data['label'][] = $label;
              $data['color'][] = $color[$k];
              $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[$k] . '"> </span> ' . $label . '</div>';
          }
          $data['data'] = array_values($data['data']);
          return $data;
      }
	  
      /**
       * Stats::exportMembershipPayments()
       * 
       * @return
       */
      public static function exportMembershipPayments($id)
      {
          $sql = "
		  SELECT 
			p.txn_id,
			CONCAT(u.fname,' ',u.lname) as name,
			p.rate_amount,
			p.tax,
			p.coupon,
			p.total,
			p.currency,
			p.pp,
			p.created
		  FROM
			`" . Membership::pTable . "` AS p 
			LEFT JOIN `" . Users::mTable . "` AS u 
			  ON u.id = p.user_id 
		  WHERE p.membership_id = ?
		  AND p.status = ?
		  ORDER BY p.created DESC;";
		  
		  $rows = Db::run()->pdoQuery($sql, array($id, 1))->results();
		  $array = json_decode(json_encode($rows), true);
		  
          return $array ? $array : 0;

      }
	  
      /**
       * Stats::deleteInactive()
       * 
	   * @param int $days
       * @return
       */
      public static function deleteInactive($days)
      {
          $sql = "
		  DELETE 
		  FROM
			`" . Users::mTable . "` 
		  WHERE DATE(lastlogin) < DATE_SUB(CURDATE(), INTERVAL $days DAY) 
			AND TYPE = ? 
			AND active = ?;";
		  
		  Db::run()->pdoQuery($sql, array("member", "y"))->results();
		  $total = Db::run()->affected();
		  
		  Message::msgReply($total, 'success', Message::formatSuccessMessage($total, Lang::$word->MT_DELINCT_OK));

      }
	  
      /**
       * Stats::deleteBanned()
       * 
	   * @param int $days
       * @return
       */
      public static function deleteBanned()
      {
		  
		  Db::run()->delete(Users::mTable, array("active" => "b"));
		  $total = Db::run()->affected();
		  
		  Message::msgReply($total, 'success', Message::formatSuccessMessage($total, Lang::$word->MT_DELBND_OK));

      }
	  
      /**
       * Stats::emptyCart()
       * 
	   * @param int $days
       * @return
       */
      public static function emptyCart()
      {
          $sql = "
		  DELETE 
		  FROM
			`" . Membership::cTable . "` 
		  WHERE DATE(created) < DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
		  
		  Db::run()->pdoQuery($sql)->results();
		  $total = Db::run()->affected();
		  
		  Message::msgReply($total, 'success', Message::formatSuccessMessage($total, Lang::$word->MT_DELCRT_OK));

      }
	  
      /**
       * Stats::getAllSalesStats()
       * 
       * @return
       */
      public static function getAllSalesStats()
      {
          $range = (isset($_GET['timerange'])) ? Validator::sanitize($_GET['timerange'], "string", 6) : 'all';

          $data = array();
          $data['label'] = array();
          $data['color'] = array();
          $data['legend'] = array();
		  $data['preUnits'] = Utility::currencySymbol(); 
		  
          $color = array(
              "#03a9f4",
              "#33BFC1",
              "#ff9800",
              "#e91e63",
              );
			  
          $labels = array(
              Lang::$word->TRX_SALES,
              Lang::$word->TRX_AMOUNT,
              Lang::$word->TRX_TAX,
              Lang::$word->TRX_COUPON,
			  );
			  
          switch ($range) {
              case 'day':
				for ($i = 0; $i < 24; $i++) {
					$data['data'][$i]['m'] = $i;
					$reg_data[$i] = array(
						'hour' => $i,
						'sales' => 0,
						'amount' => 0,
						'tax' => 0,
						'coupon' => 0,
						);
				}
				
				$sql = ("
				  SELECT 
					COUNT(id) AS sales,
					SUM(rate_amount) AS amount,
					SUM(tax) AS tax,
					SUM(coupon) AS coupon,
					HOUR(created) as hour
				  FROM
					`" . Membership::pTable . "` 
					WHERE DATE(created) = DATE(NOW())
					AND status = ?
				  GROUP BY HOUR(created)
				  ORDER BY hour ASC;
				");
				$query = Db::run()->pdoQuery($sql, array(1));
	  
				foreach ($query->results() as $result) {
					$reg_data[$result->hour] = array(
						'hour' => $result->hour,
						'sales' => $result->sales,
						'amount' => $result->amount,
						'tax' => $result->tax,
						'coupon' => $result->coupon
						);
				}
			  break;
			  
              case 'week':
			   $date_start = strtotime('-' . date('w') . ' days');
				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));
					$data['data'][$i]['m'] = Date::dodate("EE", date('D', strtotime($date)));
					$reg_data[date('w', strtotime($date))] = array(
						'day' => date('D', strtotime($date)),
						'sales' => 0,
						'amount' => 0,
						'tax' => 0,
						'coupon' => 0,
						);
				}
				
				$sql = ("
				  SELECT 
					COUNT(id) AS sales,
					SUM(rate_amount) AS amount,
					SUM(tax) AS tax,
					SUM(coupon) AS coupon,
					DAYNAME(created) as created
				  FROM
					`" . Membership::pTable . "` 
					WHERE DATE(created) >= DATE('" . Validator::sanitize(date('Y-m-d', $date_start), "string", 10) . "')
					AND status = ?
				  GROUP BY DAYNAME(created);
				");
				$query = Db::run()->pdoQuery($sql, array(1));
	  
				foreach ($query->results() as $result) {
					$reg_data[$result->created] = array(
						'day' => $result->created,
						'sales' => $result->sales,
						'amount' => $result->amount,
						'tax' => $result->tax,
						'coupon' => $result->coupon
						);
				}
			  break;
				  
              case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					$data['data'][$i]['m'] = date('d', strtotime($date));
					$reg_data[date('j', strtotime($date))] = array(
						'day' => date('d', strtotime($date)),
						'sales' => 0,
						'amount' => 0,
						'tax' => 0,
						'coupon' => 0,
						);
				}
	  
				$sql = ("
				  SELECT 
					COUNT(id) AS sales,
					SUM(rate_amount) AS amount,
					SUM(tax) AS tax,
					SUM(coupon) AS coupon,
					DAY(created) as created
				  FROM
					`" . Membership::pTable . "` 
					WHERE MONTH(created) = MONTH(CURDATE())
					AND status = ?
				  GROUP BY DAY(created);
				");
				$query = Db::run()->pdoQuery($sql, array(1));
	  
				foreach ($query->results() as $result) {
					$reg_data[$result->created] = array(
						'month' => $result->created,
						'sales' => $result->sales,
						'amount' => $result->amount,
						'tax' => $result->tax,
						'coupon' => $result->coupon
						);
				}
			  break;
			  
              case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$data['data'][$i]['m'] = Date::dodate("MMM", date("F", mktime(0, 0, 0, $i, 10)));
					$reg_data[$i] = array(
						'month' => date('M', mktime(0, 0, 0, $i)),
						'sales' => 0,
						'amount' => 0,
						'tax' => 0,
						'coupon' => 0,
						);
				}
	  
				$sql = ("
				  SELECT 
					COUNT(id) AS sales,
					SUM(rate_amount) AS amount,
					SUM(tax) AS tax,
					SUM(coupon) AS coupon,
					MONTH(created) as created
				  FROM
					`" . Membership::pTable . "` 
					WHERE YEAR(created) = YEAR(NOW())
					AND status = ?
				  GROUP BY MONTH(created);
				");
				$query = Db::run()->pdoQuery($sql, array(1));
	  
				foreach ($query->results() as $result) {
					$reg_data[$result->created] = array(
						'month' => Date::dodate("MMM", date("F", mktime(0, 0, 0, $result->created, 10))),
						'sales' => $result->sales,
						'amount' => $result->amount,
						'tax' => $result->tax,
						'coupon' => $result->coupon
						);
				}
	  			  break;
			  
              case 'all':
				for ($i = 1; $i <= 12; $i++) {
					$data['data'][$i]['m'] = Date::dodate("MMM", date("F", mktime(0, 0, 0, $i, 10)));
					$reg_data[$i] = array(
						'month' => date('M', mktime(0, 0, 0, $i)),
						'sales' => 0,
						'amount' => 0,
						'tax' => 0,
						'coupon' => 0,
						);
				}
	  
				$sql = ("
				  SELECT 
					COUNT(id) AS sales,
					SUM(rate_amount) AS amount,
					SUM(tax) AS tax,
					SUM(coupon) AS coupon,
					MONTH(created) as created
				  FROM
					`" . Membership::pTable . "` 
					WHERE status = ?
				  GROUP BY MONTH(created);
				");
				$query = Db::run()->pdoQuery($sql, array(1));
	  
				foreach ($query->results() as $result) {
					$reg_data[$result->created] = array(
						'month' => Date::dodate("MMM", date("F", mktime(0, 0, 0, $result->created, 10))),
						'sales' => $result->sales,
						'amount' => $result->amount,
						'tax' => $result->tax,
						'coupon' => $result->coupon
						);
				}
			  break;
			  
		  }
		  
		  foreach ($reg_data as $key => $value) {
			  $data['data'][$key][Lang::$word->TRX_SALES] = $value['sales'];
			  $data['data'][$key][Lang::$word->TRX_AMOUNT] = $value['amount'];
			  $data['data'][$key][Lang::$word->TRX_TAX] = $value['tax'];
			  $data['data'][$key][Lang::$word->TRX_COUPON] = $value['coupon'];
		  }

		  foreach ($labels as $k => $label) {
			  $data['label'][] = $label;
			  $data['color'][] = $color[$k];
			  $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[$k] . '"> </span> ' . $label . '</div>';
		  }
		  $data['data'] = array_values($data['data']);
		  return $data;
	  }
	  
      /**
       * Stats::getAllStats()
       * 
       * @return
       */
      public static function getAllStats()
      {
		  
		  $enddate = (Validator::post('enddate') && $_POST['enddate'] <> "") ? Validator::sanitize(Db::toDate($_POST['enddate'], false)) : date("Y-m-d");
		  $fromdate = Validator::post('fromdate') ? Validator::sanitize(Db::toDate($_POST['fromdate'], false)) : null;
		  
          if (Validator::post('fromdate') && $_POST['fromdate'] <> "") {
              $counter = Db::run()->count(false, false, "SELECT COUNT(*) FROM `" . Membership::pTable . "` WHERE `created` BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND status = 1");
              $where = "WHERE p.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND p.status = 1";

          } else {
			  $counter = Db::run()->count(Membership::pTable);
              $where = null;
          }
		  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = App::Core()->perpage;
          $pager->path = Url::url(Router::$path, "?");
          $pager->paginate();
		  
          $sql = "
		  SELECT 
			p.*,
			m.title,
			CONCAT(u.fname,' ',u.lname) as name
		  FROM `" . Membership::pTable . "` as p 
			LEFT JOIN " . Users::mTable . " AS u 
			  ON p.user_id = u.id
			LEFT JOIN " . Membership::mTable . " AS m 
			  ON p.membership_id = m.id
		  $where
		  ORDER BY p.created DESC " . $pager->limit;

          $row = Db::run()->pdoQuery($sql)->results();
		  
          return ($row) ? [$row, $pager] : 0;
		  
	  }
	  
	        /**
       * Stats::exportAllTransactions()
       * 
       * @return
       */
      public static function exportAllTransactions()
      {
          $sql = "
		  SELECT 
			p.txn_id,
			m.title,
			CONCAT(u.fname,' ',u.lname) as name,
			p.rate_amount,
			p.tax,
			p.coupon,
			p.total,
			p.currency,
			p.pp,
			p.created
		  FROM
			`" . Membership::pTable . "` AS p 
			LEFT JOIN `" . Users::mTable . "` AS u 
			  ON u.id = p.user_id 
			LEFT JOIN `" . Membership::mTable . "` AS m 
			  ON m.id = p.membership_id 
		  ORDER BY p.created DESC;";
		  
		  $rows = Db::run()->pdoQuery($sql)->results();
		  $array = json_decode(json_encode($rows), true);
		  
          return $array ? $array : 0;

      }  

      /**
       * Stats::indexStats()
       * 
       * @return
       */
      public static function indexStats()
      {
		  
		  $users = Db::run()->count(Users::mTable, "type = 'member'");
		  $active = Db::run()->count(Users::mTable, "active = 'y' AND type = 'member'");
		  $pending = Db::run()->count(Users::mTable, "active = 't'");
		  $mems = Db::run()->count(Users::mTable, "membership_id <> 0 AND type = 'member'");
		  
		  return [$users, $active, $pending, $mems];
		  
	  }

      /**
       * Stats::indexSalesStats()
       * 
       * @return
       */
      public static function indexSalesStats()
      {

          $data = array();
          $data['label'] = array();
          $data['color'] = array();
          $data['legend'] = array();
		  
          $color = array(
              "#03a9f4",
              "#33BFC1"
              );
			  
          $labels = array(
              Lang::$word->TRX_SALES,
              Lang::$word->TRX_AMOUNT
			  );

		  for ($i = 1; $i <= 12; $i++) {
			  $data['data'][$i]['m'] = Date::dodate("MMM", date("F", mktime(0, 0, 0, $i, 10)));
			  $reg_data[$i] = array(
				  'month' => date('M', mktime(0, 0, 0, $i)),
				  'sales' => 0,
				  'amount' => 0,
				  );
		  }

          $sql = "
		  SELECT 
			COUNT(id) AS sales,
			SUM(rate_amount) AS amount,
			MONTH(created) as created
		  FROM
			`" . Membership::pTable . "` 
		  WHERE status = ?
		  GROUP BY MONTH(created);";

          $query = Db::run()->pdoQuery($sql, array(1));
          foreach ($query->results() as $result) {
              $reg_data[$result->created] = array(
                  'month' => Date::dodate("MMM", date("F", mktime(0, 0, 0, $result->created, 10))),
                  'sales' => $result->sales,
                  'amount' => $result->amount);
          }

          $totalsum = 0;
          $totalsales = 0;
		  
		  
          foreach ($reg_data as $key => $value) {
              $data['sales'][] = array($key, $value['sales']);
              $data['amount'][] = array($key, $value['amount']);
			  $data['data'][$key][Lang::$word->TRX_SALES] = $value['sales'];
			  $data['data'][$key][Lang::$word->TRX_AMOUNT] = $value['amount'];
              $totalsum += $value['amount'];
              $totalsales += $value['sales'];
          }

          $data['totalsum'] = $totalsum;
          $data['totalsales'] = $totalsales;
          $data['sales_str'] = implode(",", array_column($data["sales"], 1));
          $data['amount_str'] = implode(",", array_column($data["amount"], 1));

          foreach ($labels as $k => $label) {
              $data['label'][] = $label;
              $data['color'][] = $color[$k];
              $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[$k] . '"> </span> ' . $label . '</div>';
          }
		  $data['data'] = array_values($data['data']);
          return ($data) ? $data : 0;

      }

      /**
       * Stats::getMainStats()
       * 
       * @return
       */
      public static function getMainStats()
      {
          $data = array();
          $data['label'] = array();
          $data['color'] = array();
          $data['legend'] = array();
		  $data['preUnits'] = Utility::currencySymbol(); 

          $color = array(
              "#f44336",
              "#2196f3",
              "#e91e63",
              "#4caf50",
              "#ff9800",
              "#ff5722",
              "#795548",
              "#607d8b",
              "#00bcd4",
              "#9c27b0");

          $begin = new DateTime(date('Y') . '-01');
          $ends = new DateTime(date('Y') . '-12');
          $end = $ends->modify('+1 month');

          $interval = new DateInterval('P1M');
          $daterange = new DatePeriod($begin, $interval, $end);

          $sql = "
		  SELECT 
			DATE_FORMAT(p.created, '%Y-%m') as cdate,
			m.title,
			p.membership_id,
			p.rate_amount
		  FROM
			`" . Membership::pTable . "` AS p 
			LEFT JOIN `" . Membership::mTable . "` AS m 
			  ON m.id = p.membership_id 
		  WHERE status = ?;";
          $query = Db::run()->pdoQuery($sql, array(1))->results();
          $memberships = Utility::groupToLoop($query, "title");

          foreach ($daterange as $k => $date) {
              $data['data'][$k]['m'] = Date::dodate("MMM", $date->format("Y-m"));
              if ($memberships) {
                  foreach ($memberships as $title => $rows) {
                      $sum = 0;
                      foreach ($rows as $row) {
                          $data['data'][$k][$row->title] = $sum;
                          if ($row->cdate == $date->format("Y-m")) {
                              $sum += $row->rate_amount;
                              $data['data'][$k][$title] = $sum;
                          }
                      }

                  }

              } else {
                  $data['data'][$k]['-/-'] = 0;
              }
          }

          if ($memberships) {
              $k = 0;
              foreach ($memberships as $label => $vals) {
                  $k++;
                  $data['label'][] = $label;
                  $data['color'][] = $color[$k];
                  $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[$k] . '"> </span> ' . $label . '</div>';
              }
          } else {
              $data['label'][] = '-/-';
              $data['color'][] = $color[0];
              $data['legend'][] = '<div class="item"><span class="wojo tiny empty circular label" style="background:' . $color[0] . '"> </span> -/-</div>';
          }

          return $data;

      }
	  
      /**
       * Stats::doArraySum($array, $key)
       * 
       * @return
       */
      public static function doArraySum($array, $key)
      {
		  if (is_array($array)) {
			  return (number_format(array_sum(array_map(function ($item) use ($key){return $item->$key;}
			  , $array)),2));
		  }
	
		  return 0;
		  
	  }
 }