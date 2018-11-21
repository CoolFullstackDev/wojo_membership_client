<?php
  /**
   * Helper
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: helper.php, v1.00 2016-08-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
  require_once("../../init.php");
	  
  if (!App::Auth()->is_Admin())
      exit;

  /* == Live Search == */
  if (isset($_GET['liveSearch'])):
      $string = Validator::sanitize($_GET['value'], 'string', 15);
      switch (Validator::get('type')):
          case "users":
              if (strlen($string) > 3):
                  $sql = "
					SELECT 
					  id,
					  username,
					  email,
					  mem_expire,
					  CONCAT(fname, ' ', lname) AS name
					FROM
					  `" . Users::mTable . "`
					WHERE MATCH (fname) AGAINST ('" . $string . "*' IN BOOLEAN MODE)
					OR MATCH (lname) AGAINST ('" . $string . "*' IN BOOLEAN MODE)
					OR MATCH (username) AGAINST ('" . $string . "*' IN BOOLEAN MODE)
					OR MATCH (email) AGAINST ('" . $string . "*' IN BOOLEAN MODE)
					ORDER BY fname
					LIMIT 10 ";

                  $html = '';
                  if ($result = Db::run()->pdoQuery($sql)->results()):
                      $html .= '<table class="wojo basic dashed table">';
                      foreach ($result as $row):
                          $link = Url::url("/admin/users/edit", $row->id);
                          $html .= '<tr>';
                          $html .= '<td>';
                          $html .= '<span class="wojo basic disabled label">' . $row->id . '</span>';
                          $html .= '</td>';
                          $html .= '<td class="wojo large text">';
                          $html .= '<a href="' . $link . '" class="white">' . $row->name . '</a>';
                          $html .= '</td>';
	                      $html .= '<td class="wojo large text">';
                          $html .= $row->username;
                          $html .= '</td>';
	                      $html .= '<td class="wojo large text">';
                          $html .= $row->email;
                          $html .= '</td>';
	                      $html .= '<td class="wojo large text">';
                          $html .= $row->mem_expire ? Date::doDate("short_date", $row->mem_expire) : null;
                          $html .= '</td>';
                          $html .= '</tr>';
                      endforeach;
                      $html .= '</table>';
					  $json['html'] = $html;
					  $json['status'] = 'success';
                  else:
					  $json['status'] = 'error';
                  endif;
				  print json_encode($json);
              endif;
          break;
      endswitch;

  endif;

  /* == Post Actions== */
  if (isset($_POST['processItem'])):
	  switch ($_POST['page']) :
		  /* == Update Role Description == */
		  case "editRole":
			  App::Users()->updateRoleDescription();
		  break;  
		  /* == Process Notification == */
		  case "resendNotification":
			  App::Users()->resendNotification();
		  break;
		  /* == Rename File == */
		  case "renameFile":
			  App::Content()->renameFile();
		  break;
      endswitch;
  endif;
  
  /* == Get Actions== */
  if (isset($_GET['doAction'])):
      switch ($_GET['page']) :
          /* == Edit Role == */
          case "editRole":
			  $tpl = App::View(BASEPATH . 'view/admin/snippets/'); 
			  $tpl->data = Db::run()->first(Users::rTable, null, array('id' => Filter::$id));
			  $tpl->template = 'editRole.tpl.php'; 
			  echo $tpl->render(); 
          break;
          /* == Resend Notification == */
          case "resendNotification":
			  $tpl = App::View(BASEPATH . 'view/admin/snippets/'); 
			  $tpl->template = 'resendNotification.tpl.php'; 
			  $tpl->data = Db::run()->first(Users::mTable, array("id", "email", "CONCAT(fname,' ',lname) as name"), array('id' => Filter::$id));
			  echo $tpl->render(); 
          break;
          /* == Rename File == */
          case "renameFile":
			  $tpl = App::View(BASEPATH . 'view/admin/snippets/'); 
			  $tpl->template = 'renameFile.tpl.php'; 
			  $tpl->data = Db::run()->first(Content::fTable, null, array('id' => Filter::$id));
			  $tpl->mlist = App::Membership()->getMembershipList();
			  echo $tpl->render(); 
          break;
          /* == Load Language Section == */
          case "loadLanguageSection":
			  $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . ".lang.xml");
			  $section = $xmlel->xpath('/language/phrase[@section="' . Validator::sanitize($_GET['section']) . '"]');
			  $tpl = App::View(BASEPATH . 'view/admin/snippets/'); 
			  $tpl->xmlel = $xmlel;
			  $tpl->section = $section;
			  $tpl->template = 'loadLanguageSection.tpl.php'; 
			  $json['html'] = $tpl->render(); 
			  print json_encode($json);
          break;
      endswitch;
  endif;

  /* == Quick Edit == */
  if (isset($_POST['quickedit'])):
      $title = Validator::cleanOut($_POST['title']);
      $title = Validator::sanitize($title);
      switch ($_POST['type']) :
          /* == Update Language Phrase == */
          case "phrase":
			  if (file_exists(BASEPATH . Lang::langdir . Core::$language . ".lang.xml")):
				  $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . ".lang.xml");
				  $node = $xmlel->xpath("/language/phrase[@data = '" . $_POST['key'] . "']");
				  $node[0][0] = $title;
				  $xmlel->asXML(BASEPATH . Lang::langdir . Core::$language . ".lang.xml");
			  endif;
              break;  
          /* == Update Country Vat == */
          case "tax":
              if (empty($_POST['title'])):
                  print '0.000';
                  exit;
              endif;
              if ($vat = is_int($title)):
                  $data['vat'] = $vat;
				  Db::run()->update(Content::cTable, $data, array('id' => Filter::$id));
              endif;
          break;
      endswitch;
	  $json['title'] = $title;
	  print json_encode($json);
  endif;

  /* == Quick Status == */
  if (Validator::post('quickStatus')):
      switch ($_POST['status']) :
          /* == Roles == */
          case "role":
		      if(Auth::checkAcl("owner")):
			      Db::run()->update(Users::rpTable, array("active" => intval($_POST['active'])), array("id" => Filter::$id));
			  endif;
          break;
          /* == Coupons == */
          case "coupon":
		      Db::run()->update(Content::dcTable, array("active" => intval($_POST['active'])), array("id" => Filter::$id));
          break;
          /* == Gateway == */
          case "gateway":
		      Db::run()->update(AdminController::gTable, array("active" => intval($_POST['active'])), array("id" => Filter::$id));
          break;
      endswitch;
  endif;

  /* == Quick Simple Actions == */
  if (Validator::post('simpleAction')) :
      switch ($_POST['action']) :
              /* == Database Backup == */
          case "databaseBackup":
              dbTools::doBackup();
          break;
		  /* == Restore User == */
		  case "restoreUser":
			  if($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
				  $array = Utility::jSonToArray($result->dataset);
				  Core::restoreFromTrash($array, Users::mTable);
				  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  endif;
		  break;
		  /* == Delete User == */
		  case "deleteUser":
			  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  $json['type'] = "success";
			  print json_encode($json);
		  break; 
		  
		  /* == Restore Coupon == */
		  case "restoreCoupon":
			  if($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
				  $array = Utility::jSonToArray($result->dataset);
				  Core::restoreFromTrash($array, Content::dcTable);
				  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  endif;
		  break;
		  /* == Delete Coupon == */
		  case "deleteCoupon":
			  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  $json['type'] = "success";
			  print json_encode($json);
		  break; 
		  
		  /* == Restore News == */
		  case "restoreNews":
			  if($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
				  $array = Utility::jSonToArray($result->dataset);
				  Core::restoreFromTrash($array, Content::nTable);
				  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  endif;
		  break;
		  /* == Delete News == */
		  case "deleteNews":
			  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  $json['type'] = "success";
			  print json_encode($json);
		  break; 
		  
		  /* == Restore Membership == */
		  case "restoreMembership":
			  if($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
				  $array = Utility::jSonToArray($result->dataset);
				  Core::restoreFromTrash($array, Membership::mTable);
				  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  endif;
		  break;
		  /* == Delete Membership == */
		  case "deleteMembership":
			  Db::run()->delete(Core::txTable, array("id" => filter::$id));
			  $json['type'] = "success";
			  print json_encode($json);
		  break; 
              /* == File Upload == */
          case "fileUpload":
			  if (!empty($_FILES['file']['name'])):
				  $upl = Upload::instance(Content::FS, Content::FE);
				  $upl->process("file", App::Core()->file_dir, 'SOURCE_');
				  if (empty(Message::$msgs)):
					  $data = array(
						  'alias' => $upl->fileInfo['name'],
						  'name' => $upl->fileInfo['fname'],
						  'filesize' => $upl->fileInfo['size'],
						  'extension' => $upl->fileInfo['ext'],
						  'type' => $upl->fileInfo['type_short'],
						  'token' => Utility::randomString(16),
						  'fileaccess' => 0,
						  );
						  
					  $last_id = Db::run()->insert(Content::fTable, $data)->getLastInsertId(); 
					  $tpl = App::View(BASEPATH . 'view/admin/snippets/');
					  $tpl->row = Db::run()->first(Content::fTable, null, array('id' => $last_id)); 
					  $tpl->template = 'loadFile.tpl.php'; 
			  
					  $json['type'] = "success";
					  $json['filecolor'] = Content::fileStyle($upl->fileInfo['type_short']);
					  $json['filetype'] = Content::fileIcon($upl->fileInfo['type_short'], "");
					  $json['id'] = $last_id;
					  $json['html'] = $tpl->render();
				  else:
					  $json['type'] = "error";
					  $json['message'] = Message::$msgs['name'];
				  endif;
				  print json_encode($json);
			  endif;
          break;
      endswitch;
  endif;
  
   /* == Sort Custom Fields == */
  if (Validator::post('sortFields')):
      $i = 0;
      $query = "UPDATE `" . Content::cfTable . "` SET `sorting` = CASE ";
      $idlist = '';
      foreach ($_POST['sorting'] as $item):
          $i++;
          $query .= " WHEN id = " . $item . " THEN " . $i . " ";
          $idlist .= $item . ',';
      endforeach;
      $idlist = substr($idlist, 0, -1);
      $query .= "
			  END
			  WHERE id IN (" . $idlist . ")";
      Db::run()->pdoQuery($query);
  endif;
  
   /* == Export Users == */
  if (isset($_GET['exportUsers'])):
      header("Pragma: no-cache");
	  header('Content-Type: text/csv; charset=utf-8');
	  header('Content-Disposition: attachment; filename=UserList.csv');
	  
	  $data = fopen('php://output', 'w');
	  fputcsv($data, array('Name', 'Membership', 'Expire', 'Email', 'Newsletter', 'Created'));
	  
	  $result = Stats::exportUsers();
	  if($result):
		  foreach ($result as $row) :
			  fputcsv($data, $row);
		  endforeach;
	  endif;
  endif;

   /* == Export User Payments == */
  if (isset($_GET['exportUserPayments'])):
      header("Pragma: no-cache");
	  header('Content-Type: text/csv; charset=utf-8');
	  header('Content-Disposition: attachment; filename=UserPayments.csv');
	  
	  $data = fopen('php://output', 'w');
	  fputcsv($data, array('TXN ID', 'Name', 'Amount', 'TAX/VAT', 'Coupon', 'Total Amount', 'Currency', 'Processor', 'Created'));
	  
	  $result = Stats::exportUserPayments(Filter::$id);
	  if($result):
		  foreach ($result as $row) :
			  fputcsv($data, $row);
		  endforeach;
	  endif;
  endif;

   /* == Export Membership Payments == */
  if (isset($_GET['exportMembershipPayments'])):
      header("Pragma: no-cache");
	  header('Content-Type: text/csv; charset=utf-8');
	  header('Content-Disposition: attachment; filename=MembershipPayments.csv');
	  
	  $data = fopen('php://output', 'w');
	  fputcsv($data, array('TXN ID', 'User', 'Amount', 'TAX/VAT', 'Coupon', 'Total Amount', 'Currency', 'Processor', 'Created'));
	  
	  $result = Stats::exportMembershipPayments(Filter::$id);
	  if($result):
		  foreach ($result as $row) :
			  fputcsv($data, $row);
		  endforeach;
	  endif;
  endif;

   /* == Export All Payments == */
  if (isset($_GET['exportAllTransactions'])):
      header("Pragma: no-cache");
	  header('Content-Type: text/csv; charset=utf-8');
	  header('Content-Disposition: attachment; filename=AllPayments.csv');
	  
	  $data = fopen('php://output', 'w');
	  fputcsv($data, array('TXN ID', 'Item', 'User', 'Amount', 'TAX/VAT', 'Coupon', 'Total Amount', 'Currency', 'Processor', 'Created'));
	  
	  $result = Stats::exportAllTransactions();
	  if($result):
		  foreach ($result as $row) :
			  fputcsv($data, $row);
		  endforeach;
	  endif;
  endif;
  	
   /* == User Payments Chart == */
  if (isset($_GET['getUserPaymentsChart'])):
      $data = Stats::getUserPaymentsChart(Filter::$id);
	  print json_encode($data);
  endif;

   /* == Membership Payments Chart == */
  if (isset($_GET['getMembershipPaymentsChart'])):
      $data = Stats::getMembershipPaymentsChart(Filter::$id);
	  print json_encode($data);
  endif;

   /* == Site Sales Chart == */
  if (isset($_GET['getSalesChart'])):
      $data = Stats::getAllSalesStats();
	  print json_encode($data);
  endif;

   /* == Index Payments Chart == */
  if (isset($_GET['getIndexStats'])):
      $data = Stats::indexSalesStats();
	  print json_encode($data);
  endif;

  /* == Main Stats == */
  if (isset($_GET['getMainStats'])):
      $data = Stats::getMainStats();
	  print json_encode($data);
  endif;
  
  /* == Clear Session Temp Queries == */
  if (isset($_GET['ClearSessionQueries'])):
      App::Session()->remove('debug-queries');
	  App::Session()->remove('debug-warnings');
	  App::Session()->remove('debug-errors');
	  print 1;
  endif;