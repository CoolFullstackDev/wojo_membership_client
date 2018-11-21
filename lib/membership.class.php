<?php
  /**
   * Membership Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: membership.class.php, v1.00 2016-04-20 18:20:24 gewa Exp $
   */

  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class Membership
  {
      const mTable = "memberships";
	  const umTable = "user_memberships";
      const pTable = "payments";
	  const cTable = "cart";

      /**
       * Membership::__construct()
       * 
       * @return
       */
      public function __construct()
      {

      }
	  
      /**
       * Membership::Index()
       * 
       * @return
       */
      public function Index()
      {
		  
		  $sql = "
		  SELECT 
			m.*,
			(SELECT 
			  COUNT(p.membership_id) 
			FROM
			  payments as p 
			WHERE p.membership_id = m.id) AS total
		  FROM
			memberships as m";

		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->template = 'admin/memberships.tpl.php';
		  $tpl->data = Db::run()->pdoQuery($sql)->results(); 
		  $tpl->title = Lang::$word->META_T6; 
	  }

      /**
       * Membership::Edit()
       * 
	   * @param mixed $id
       * @return
       */
	  public function Edit($id)
	  {
		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->META_T7;
		  $tpl->crumbs = ['admin', 'memberships', 'edit'];
	
		  if (!$row = Db::run()->first(self::mTable, null, array("id =" => $id))) {
			  $tpl->template = 'admin/error.tpl.php';
			  $tpl->error = DEBUG ? "Invalid ID ($id) detected [membership.class.php, ln.:" . __line__ . "]" : Lang::$word->META_ERROR;
		  } else {
			  $tpl->data = $row;
			  $tpl->template = 'admin/memberships.tpl.php';
		  }
	  }

      /**
       * Membership::Save()
       * 
       * @return
       */
	  public function Save()
	  {
		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->META_T8;
		  $tpl->template = 'admin/memberships.tpl.php';
	  }

      /**
       * Membership::History()
       * 
	   * @param mixed $id
       * @return
       */
	  public function History($id)
	  {

		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->META_T9;
		  $tpl->crumbs = ['admin', 'memberships', 'history'];
	
		  if (!$row = Db::run()->first(self::mTable, null, array("id =" => $id))) {
			  $tpl->template = 'admin/error.tpl.php';
			  $tpl->error = DEBUG ? "Invalid ID ($id) detected [membership.class.php, ln.:" . __line__ . "]" : Lang::$word->META_ERROR;
		  } else {

			  $pager = Paginator::instance();
			  $pager->items_total = Db::run()->count(self::pTable, 'membership_id = ' . $id . ' AND status = 1');
			  $pager->default_ipp = App::Core()->perpage;
			  $pager->path = Url::url(Router::$path, "?");
			  $pager->paginate();
			  
			  $sql = "
			  SELECT 
				p.rate_amount,
				p.tax,
				p.coupon,
				p.total,
				p.currency,
				p.created,
				p.user_id,
				CONCAT(u.fname,' ',u.lname) as name
			  FROM
				`" . self::pTable . "` AS p 
				LEFT JOIN " . Users::mTable . " AS u 
				  ON u.id = p.user_id 
			  WHERE p.membership_id = ?
			  AND p.status = ?
			  ORDER BY p.created DESC" . $pager->limit . ";";

			  $tpl->data = $row;
			  $tpl->plist = Db::run()->pdoQuery($sql, array($id, 1))->results();
			  $tpl->pager = $pager;
			  $tpl->template = 'admin/memberships.tpl.php';
		  }
	  }
	  
      /**
       * Membership::getMembershipList()
       * 
       * @return
       */
	  public function getMembershipList()
	  {
	
		  $row = Db::run()->select(self::mTable, array("id","title"), null, "ORDER BY title")->results();
		  return ($row) ? $row : 0;
	  }

      /**
       * Membership::getMemberships()
       * 
       * @return
       */
	  public static function getMemberships()
	  {
	
		  $row = Db::run()->select(self::mTable, null, null, "ORDER BY price")->results();
		  return ($row) ? $row : 0;
	  }

      /**
       * Membership::processMembership()
       * 
       * @return
       */
	  public function processMembership()
	  {
	
		  $rules = array(
			  'title' => array('required|string|min_len,3|max_len,60', Lang::$word->NAME),
			  'price' => array('required|numeric', Lang::$word->MEM_PRICE),
			  'days' => array('required|numeric', Lang::$word->MEM_DAYS),
			  'period' => array('required|alpha|min_len,1|max_len,1', Lang::$word->MEM_DAYS),
			  'recurring' => array('required|numeric', Lang::$word->MEM_REC),
			  'private' => array('required|numeric', Lang::$word->MEM_PRIVATE),
			  'active' => array('required|numeric', Lang::$word->PUBLISHED),
			  );
	
		  $filters = array(
			  'description' => 'trim|string',
			  );
			  
			  
		  if (!empty($_FILES['thumb']['name']) and empty(Message::$msgs)) {
			  $upl = Upload::instance(3145728, "png,jpg");
			  $upl->process("thumb", UPLOADS .'/memberships/', "MEM_");
		  }

		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);
		  
		  if (empty(Message::$msgs)) {
			  $data = array(
				  'title' => $safe->title,
				  'description' => $safe->description,
				  'price' => $safe->price,
				  'days' => $safe->days,
				  'period' => $safe->period,
				  'recurring' => $safe->recurring,
				  'private' => $safe->private,
				  'active' => $safe->active,
				  );
				  
			  if (!empty($_FILES['thumb']['name'])) {
				  $data['thumb'] = $upl->fileInfo['fname'];
			  }
	
			  (Filter::$id) ? Db::run()->update(self::mTable, $data, array("id" => Filter::$id)) : $last_id = Db::run()->insert(self::mTable, $data)->getLastInsertId(); 
			  
			  $message = Filter::$id ? 
			  Message::formatSuccessMessage($data['title'], Lang::$word->MEM_UPDATE_OK) : 
			  Message::formatSuccessMessage($data['title'], Lang::$word->MEM_ADDED_OK);
			  
			  Message::msgReply(Db::run()->affected(), 'success', $message);
		  } else {
			  Message::msgSingleStatus();
		  }
	  }
	  
      /**
       * Membership::processGateway()
       * 
       * @return
       */
      public function processGateway()
      {

		  $validate = Validator::instance();
		  $validate->addSource($_POST);
		  $validate->addRule('displayname', 'string', true, 3, 100, Lang::$word->GW_NAME);
		  $validate->addRule('extra', 'string', false);
		  $validate->addRule('extra2', 'string', false);
		  $validate->addRule('extra3', 'string', false);
		  $validate->addRule('active', 'numeric', false);
		  $validate->addRule('live', 'numeric', false);
		  $validate->run();
		  
          if (empty(Message::$msgs)) {
              $data = array(
					'displayname' => $validate->safe->displayname, 
					'extra' => $validate->safe->extra, 
					'extra2' => $validate->safe->extra2, 
					'extra3' => $validate->safe->extra3, 
					'live' => $validate->safe->live, 
					'active' => $validate->safe->active
			  );

              self::$db->update(self::gTable, $data, array('id' => Filter::$id));
              $message = Message::formatSuccessMessage($data['displayname'], Lang::$word->GW_UPDATED);
			  Message::msgReply(self::$db->affected(), 'success', $message);
			  Logger::writeLog($message);
          } else {
              Message::msgSingleStatus();
          }
      }

      /**
       * Membership::calculateTax()
       * 
	   * @param bool $uid
       * @return
       */
	  public static function calculateTax($uid = false)
	  {
		  if (App::Core()->enable_tax) {
			  if ($uid) {
				  $cnt = Db::run()->first(Users::mTable, array("country"), array("id" => $uid));
				  if ($cnt) {
					  $row = Db::run()->first(Content::cTable, array("vat"), array("abbr" => $cnt->country));
					  return ($row->vat / 100);
				  } else {
					  return 0;
				  }
			  } else {
				  if (App::Auth()->country) {
					  $row = Db::run()->first(Content::cTable, array("vat"), array("abbr" => App::Auth()->country));
					  return ($row->vat / 100);
				  } else {
					  return 0;
				  }
			  }
		  } else {
			  return 0;
		  }
	  }

      /**
       * Membership::getCart()
       * 
	   * @param bool $uid
       * @return
       */
	  public static function getCart($uid = false)
	  {
		  $id = ($uid) ? intval($uid) : App::Auth()->uid;
		  $row = Db::run()->first(self::cTable, null, array("uid" => $id));
		  
		  return ($row) ? $row : 0; 
	  }

      /**
       * Membership::is_valid()
       * 
       * @return
       */
	  public static function is_valid(array $mid)
	  {
		  if (in_array(App::Auth()->membership_id, $mid)) {
			  return true;
		  } else {
			  return false;
		  }
	  }
	  
      /**
       * Membership::calculateDays()
       * 
	   * @param bool $membership_id
       * @return
       */
      public static function calculateDays($membership_id)
      {

          $row = Db::run()->first(Membership::mTable, array('days', 'period'), array('id' => $membership_id));
          if ($row) {
              switch ($row->period) {
                  case "D":
                      $diff = ' day';
                      break;
                  case "W":
					  $diff = ' week';
                      break;
                  case "M":
					  $diff = ' month';
                      break;
                  case "Y":
					  $diff = ' year';
                      break;
              }
              $expire = Date::NumberOfDays('+' . $row->days . $diff);
          } else {
              $expire = "";
          }
          return $expire;
      }
  }