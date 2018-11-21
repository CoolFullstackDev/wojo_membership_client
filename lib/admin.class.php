<?php
  /**
   * Class Admin
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: admin.class.php, v1.00 2016-04-20 18:20:24 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');


  class AdminController
  {
	  
	  const gTable = "gateways";
	  

      /**
       * AdminController::Index()
       * 
       * @return
       */
      public function Index()
      {
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
		  $tpl->counters = Stats::indexStats();
		  $tpl->stats = Stats::indexSalesStats();
          $tpl->template = 'admin/index.tpl.php';
          $tpl->title = Lang::$word->META_T1;
      }


      /**
       * AdminController::Account()
       * 
       * @return
       */
      public function Account()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->M_TITLE];
          $tpl->template = 'admin/myaccount.tpl.php';
          $tpl->data = Db::run()->first(Users::mTable, null, array('id' => App::Auth()->uid));
          $tpl->title = Lang::$word->M_TITLE;

      }

      /**
       * AdminController::Password()
       * 
       * @return
       */
      public function Password()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->M_SUB2];
          $tpl->template = 'admin/myaccount.tpl.php';
          $tpl->title = Lang::$word->M_SUB2;

      }

      /**
       * AdminController::updateAccount()
       * 
       * @return
       */
      public function updateAccount()
      {

          $rules = array(
              'email' => array('required|email', Lang::$word->M_EMAIL),
              'fname' => array('required|string|min_len,2|max_len,60', Lang::$word->M_FNAME),
              'lname' => array('required|string|min_len,2|max_len,60', Lang::$word->M_LNAME),
              );

          $upl = Upload::instance(512000, "png,jpg");
          if (!empty($_FILES['avatar']['name']) and empty(Message::$msgs)) {
              $upl->process("avatar", UPLOADS . "/avatars/", "AVT_");
          }

          $validate = Validator::instance();
          $safe = $validate->doValidate($_POST, $rules);

          if (empty(Message::$msgs)) {
              $data = array(
                  'email' => $safe->email,
                  'lname' => $safe->lname,
                  'fname' => $safe->fname);

              if (isset($upl->fileInfo['fname'])) {
                  $data['avatar'] = $upl->fileInfo['fname'];
                  if (Auth::$udata->avatar != "") {
                      File::deleteFile(UPLOADS . "/avatars/" . Auth::$udata->avatar);
                      Auth::$udata->avatar = App::Session()->set('avatar', $upl->fileInfo['fname']);
                  }
              }
              Db::run()->update(Users::mTable, $data, array("id" => Auth::$udata->uid));
              if (Db::run()->affected()) {
                  Auth::$udata->fname = App::Session()->set('fname', $data['fname']);
                  Auth::$udata->lname = App::Session()->set('lname', $data['lname']);
                  Auth::$udata->email = App::Session()->set('email', $data['email']);
              }
              $message = str_replace("[NAME]", "", Lang::$word->M_UPDATED);
              Message::msgReply(Db::run()->affected(), 'success', $message);
          } else {
              Message::msgSingleStatus();
          }
      }


      /**
       * AdminController::updateAdminPassword()
       * 
       * @return
       */
      public function updateAdminPassword()
      {

          $rules = array(
              'password' => array('required|string|min_len,6|max_len,20', Lang::$word->NEWPASS),
              'password2' => array('required|string|min_len,6|max_len,20', Lang::$word->CONPASS),
              );

          $validate = Validator::instance();
          $safe = $validate->doValidate($_POST, $rules);

          if ($_POST['password'] != $_POST['password2']) {
              Message::$msgs['pass'] = Lang::$word->M_PASSMATCH;
          }

          if (empty(Message::$msgs)) {
              $salt = '';
              $hash = App::Auth()->create_hash($safe->password, $salt);
              $data['hash'] = $hash;
              $data['salt'] = $salt;

              Db::run()->update(Users::mTable, $data, array("id" => Auth::$udata->uid));
              Message::msgReply(Db::run()->affected(), 'success', Lang::$word->M_PASSUPD_OK);
          } else {
              Message::msgSingleStatus();
          }
      }
	  
      /**
       * AdminController::Backup()
       * 
       * @return
       */
      public function Backup()
      {
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
		  $tpl->dbdir = UPLOADS . '/backups/';
		  $tpl->data = File::findFiles($tpl->dbdir, array('fileTypes' => array('sql'), 'returnType' => 'fileOnly'));
          $tpl->template = 'admin/backup.tpl.php';
          $tpl->title = Lang::$word->DBM_TITLE;
      }
	  
      /**
       * AdminController::Gateways()
       * 
       * @return
       */
      public function Gateways()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->META_T22];
          $tpl->template = 'admin/gateways.tpl.php';
          $tpl->data = Db::run()->select(self::gTable)->results();
          $tpl->title = Lang::$word->META_T22;

      }
	  
      /**
       * AdminController::GatewayEdit()
       * 
       * @return
       */
	  public function GatewayEdit($id)
	  {
		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->GW_TITLE1;
		  $tpl->crumbs = ['admin', 'gateways', 'edit'];
	
		  if (!$row = Db::run()->first(self::gTable, null, array("id =" => $id))) {
			  $tpl->template = 'admin/error.tpl.php';
			  $tpl->error = DEBUG ? "Invalid ID ($id) detected [admin.class.php, ln.:" . __line__ . "]" : Lang::$word->META_ERROR;
		  } else {
			  $tpl->data = $row;
			  $tpl->template = 'admin/gateways.tpl.php';
		  }
	  }
	  
      /**
       * Admin::processGateway()
       * 
       * @return
       */
	  public function processGateway()
	  {
	
		  $rules = array(
			  'displayname' => array('required|string|min_len,3|max_len,60', Lang::$word->GW_NAME),
			  'extra' => array('required|string', Lang::$word->GW_NAME),
			  'live' => array('required|numeric', Lang::$word->GW_LIVE),
			  'active' => array('required|numeric', Lang::$word->ACTIVE),
			  'id' => array('required|numeric', "ID"),
			  );
	
		  $filters = array(
			  'extra2' => 'string',
			  'extra3' => 'string',
			  );

		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);
		  
		  if (empty(Message::$msgs)) {
			  $data = array(
				  'displayname' => $safe->displayname,
				  'extra' => $safe->extra,
				  'extra2' => $safe->extra2,
				  'extra3' => $safe->extra3,
				  'live' => $safe->live,
				  'active' => $safe->active,
				  );
	
			  Db::run()->update(self::gTable, $data, array("id" => Filter::$id)); 
			  Message::msgReply(Db::run()->affected(), 'success', Message::formatSuccessMessage($data['displayname'], Lang::$word->GW_UPDATED));
		  } else {
			  Message::msgSingleStatus();
		  }
	  }
	  
      /**
       * AdminController::Maintenance()
       * 
       * @return
       */
      public function Maintenance()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->META_T23];
          $tpl->template = 'admin/maintenance.tpl.php';
          $tpl->banned = Db::run()->count(Users::mTable, "active = 'b' AND type = 'member'");
          $tpl->title = Lang::$word->META_T23;

      }
	  
      /**
       * AdminController::Mailer()
       * 
       * @return
       */
      public function Mailer()
      {
		  $type = Validator::get('email') ? "singleMail" : "newsletter";
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
		  $tpl->data = Db::run()->first(Content::eTable, null, array("typeid" => $type));
          $tpl->template = 'admin/mailer.tpl.php';
          $tpl->title = Lang::$word->META_T24;
      }
	  
      /**
       * AdminController::processMailer()
       * 
       * @return
       */
      public function processMailer()
      {
          $rules = array(
              'subject' => array('required|string|min_len,3|max_len,100', Lang::$word->NL_SUBJECT),
              'recipient' => array('required|string', Lang::$word->NL_RCPT),
              );

		  $filters = array(
			  'body' => 'advanced_tags',
			  );

		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);

          $upl = Upload::instance(20971520, "zip,jpg,pdf,doc,docx");
          if (!empty($_FILES['attachment']['name']) and empty(Message::$msgs)) {
              $upl->process("attachment", UPLOADS . "/attachments/", "ATT_");
          }

          if (empty(Message::$msgs)) {
              $body = Validator::cleanOut($safe->body);
              $numSent = 0;
              $failedRecipients = array();

              switch ($safe->recipient) {
                  case "all";
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
                      $userrow = Db::run()->select(Users::mTable, array('email', 'CONCAT(fname," ",lname) as name'), array('active' => 'y', 'type' => 'member'))->results();

                      $replacements = array();
                      $core = App::Core();
                      if ($userrow) {
                          if (isset($upl->fileInfo['fname'])) {
                              $attachement = '<a href="' . UPLOADURL . '/attachments/' . $upl->fileInfo['fname'] . '">' . Lang::$word->NL_ATTACH . '</a>';
                          } else {
                              $attachement = '';
                          }

                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[LOGO]' => Utility::getLogo(),
                                  '[NAME]' => $cols->name,
                                  '[DATE]' => date('Y'),
                                  '[COMPANY]' => $core->company,
                                  '[FB]' => $core->social->facebook,
                                  '[TW]' => $core->social->twitter,
                                  '[ATTACHMENT]' => $attachement,
                                  '[SITEURL]' => SITEURL);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								->setSubject($safe->subject)
								->setFrom(array($core->site_email => $core->company))
								->setBody($body, 'text/html');

                          foreach ($userrow as $row) {
                              $message->setTo(array($row->email => $row->name));
                              $numSent++;
                              $mailer->send($message, $failedRecipients);
                          }
                          unset($row);

                      }
                      break;

                  case "newsletter":
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
                      $userrow = Db::run()->select(Users::mTable, array('email', 'CONCAT(fname," ",lname) as name'), array('newsletter' => 1, 'type' => 'member'))->results();

                      $replacements = array();
                      $core = App::Core();
                      if ($userrow) {
                          if (isset($upl->fileInfo['fname'])) {
                              $attachement = '<a href="' . UPLOADURL . '/attachments/' . $upl->fileInfo['fname'] . '">' . Lang::$word->NL_ATTACH . '</a>';
                          } else {
                              $attachement = '';
                          }

                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[LOGO]' => Utility::getLogo(),
                                  '[NAME]' => $cols->name,
                                  '[DATE]' => date('Y'),
                                  '[COMPANY]' => $core->company,
                                  '[FB]' => $core->social->facebook,
                                  '[TW]' => $core->social->twitter,
                                  '[ATTACHMENT]' => $attachement,
                                  '[SITEURL]' => SITEURL);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								->setSubject($safe->subject)
								->setFrom(array($core->site_email => $core->company))
								->setBody($body, 'text/html');

                          foreach ($userrow as $row) {
                              $message->setTo(array($row->email => $row->name));
                              $numSent++;
                              $mailer->send($message, $failedRecipients);
                          }
                          unset($row);

                      }

                      break;

                  case "free":
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
                      $userrow = Db::run()->select(Users::mTable, array('email', 'CONCAT(fname," ",lname) as name'), array('membership_id' => 0, 'type' => 'member'))->results();

                      $replacements = array();
                      $core = App::Core();
                      if ($userrow) {
                          if (isset($upl->fileInfo['fname'])) {
                              $attachement = '<a href="' . UPLOADURL . '/attachments/' . $upl->fileInfo['fname'] . '">' . Lang::$word->NL_ATTACH . '</a>';
                          } else {
                              $attachement = '';
                          }

                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[LOGO]' => Utility::getLogo(),
                                  '[NAME]' => $cols->name,
                                  '[DATE]' => date('Y'),
                                  '[COMPANY]' => $core->company,
                                  '[FB]' => $core->social->facebook,
                                  '[TW]' => $core->social->twitter,
                                  '[ATTACHMENT]' => $attachement,
                                  '[SITEURL]' => SITEURL);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								->setSubject($safe->subject)
								->setFrom(array($core->site_email => $core->company))
								->setBody($body, 'text/html');

                          foreach ($userrow as $row) {
                              $message->setTo(array($row->email => $row->name));
                              $numSent++;
                              $mailer->send($message, $failedRecipients);
                          }
                          unset($row);

                      }
                      break;

                  case "paid":
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
                      $userrow = Db::run()->select(Users::mTable, array('email', 'CONCAT(fname," ",lname) as name'), array('membership_id <>' => 0, 'and type =' => 'member'))->results();

                      $replacements = array();
                      $core = App::Core();
                      if ($userrow) {
                          if (isset($upl->fileInfo['fname'])) {
                              $attachement = '<a href="' . UPLOADURL . '/attachments/' . $upl->fileInfo['fname'] . '">' . Lang::$word->NL_ATTACH . '</a>';
                          } else {
                              $attachement = '';
                          }

                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[LOGO]' => Utility::getLogo(),
                                  '[NAME]' => $cols->name,
                                  '[DATE]' => date('Y'),
                                  '[COMPANY]' => $core->company,
                                  '[FB]' => $core->social->facebook,
                                  '[TW]' => $core->social->twitter,
                                  '[ATTACHMENT]' => $attachement,
                                  '[SITEURL]' => SITEURL);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								->setSubject($safe->subject)
								->setFrom(array($core->site_email => $core->company))
								->setBody($body, 'text/html');

                          foreach ($userrow as $row) {
                              $message->setTo(array($row->email => $row->name));
                              $numSent++;
                              $mailer->send($message, $failedRecipients);
                          }
                          unset($row);

                      }
                      break;

                  default:
                      $mailer = Mailer::sendMail();
                      $userrow = Db::run()->pdoQuery("SELECT email, CONCAT(fname,' ',lname) as name FROM `" . Users::mTable . "` WHERE email LIKE '%" . $safe->recipient . "%'")->result();
                      $core = App::Core();

                      if ($userrow) {
                          if (isset($upl->fileInfo['fname'])) {
                              $attachement = '<a href="' . UPLOADURL . '/attachments/' . $upl->fileInfo['fname'] . '">' . Lang::$word->NL_ATTACH . '</a>';
                          } else {
                              $attachement = '';
                          }

						  $newbody = str_replace(array(
							  '[LOGO]',
							  '[NAME]',
							  '[DATE]',
							  '[COMPANY]',
							  '[ATTACHMENT]',
							  '[FB]',
							  '[TW]',
							  '[SITEURL]'), array(
							  Utility::getLogo(),
							  $userrow->name,
							  date('Y'),
							  $core->company,
							  $attachement,
							  $core->social->facebook,
							  $core->social->twitter,
							  SITEURL), $body);

                          $message = Swift_Message::newInstance()
								->setSubject($safe->subject)
								->setTo(array($safe->recipient => $userrow->name))
								->setFrom(array($core->site_email => $core->company))
								->setBody($newbody, 'text/html');

                          $numSent++;
                          $mailer->send($message, $failedRecipients);
                      }
                      break;
              }

              if ($numSent) {
                  $json['type'] = 'success';
                  $json['title'] = Lang::$word->SUCCESS;
                  $json['message'] = $numSent . ' ' . Lang::$word->NL_SENT;
              } else {
                  $json['type'] = 'error';
                  $json['title'] = Lang::$word->ERROR;
                  $res = '';
                  $res .= '<ul>';
                  foreach ($failedRecipients as $failed) {
                      $res .= '<li>' . $failed . '</li>';
                  }
                  $res .= '</ul>';
                  $json['message'] = Lang::$word->NL_ALERT . $res;

                  unset($failed);
              }
              print json_encode($json);
          } else {
              Message::msgSingleStatus();
          }
      }
	  
      /**
       * AdminController::Permissions()
       * 
       * @return
       */
      public function Permissions()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->M_TITLE1];
		  $tpl->data = App::Users()->getRoles();
          $tpl->template = 'admin/permissions.tpl.php';
          $tpl->title = Lang::$word->M_TITLE1;

      }

      /**
       * AdminController::Privileges()
       * 
       * @return
       */
      public function Privileges($id)
      {

		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->META_T3;
		  $tpl->crumbs = ['admin', 'permissions', Lang::$word->M_TITLE1];
	
		  if (!$row = Db::run()->first(Users::rTable, null, array('id' => $id))) {
			  $tpl->template = 'admin/error.tpl.php';
			  $tpl->error = DEBUG ? "Invalid ID ($id) detected [admin.class.php, ln.:" . __line__ . "]" : Lang::$word->META_ERROR;
		  } else {
			  $tpl->role = $row;
			  $tpl->result = Utility::groupToLoop(App::Users()->getPrivileges($id), "type");
			  $tpl->template = 'admin/permissions.tpl.php';
		  }

      }
	  
      /**
       * AdminController::System()
       * 
       * @return
       */
      public function System()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->SYS_TITLE];
		  $tpl->core = App::Core();
          $tpl->template = 'admin/system.tpl.php';
          $tpl->title = Lang::$word->SYS_TITLE;

      }
	  
      /**
       * AdminController::Transactions()
       * 
       * @return
       */
      public function Transactions()
      {
          $data = Stats::getAllStats();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->TRX_PAY];
		  $tpl->data = $data[0];
		  $tpl->pager = $data[1];
          $tpl->template = 'admin/transactions.tpl.php';
          $tpl->title = Lang::$word->TRX_PAY;

      }

      /**
       * AdminController::Files()
       * 
       * @return
       */
      public function Files()
      {
		  if (isset($_GET['letter']) and isset($_GET['type'])) {
			  $letter = Validator::sanitize($_GET['letter'], 'default', 2);
			  $type = Validator::sanitize($_GET['type'], "alpha", 10);

              if (in_array($type, array(
                  "audio",
                  "video",
                  "archive",
				  "document",
				  "image",
				  ))) {
				  $where = "WHERE `type` = '$type' AND `alias` REGEXP '^" . $letter . "'";	
				  $counter = Db::run()->count(false, false, "SELECT COUNT(*) FROM `" . Content::fTable . "` $where LIMIT 1");
              } else {
				  $where = "WHERE `alias` REGEXP '^" . $letter . "'";
                  $counter = Db::run()->count(false, false, "SELECT COUNT(*) FROM `" . Content::fTable . "` $where LIMIT 1");
              }
		  } elseif (isset($_GET['type'])) {
			  $type = Validator::sanitize($_GET['type'], "alpha", 10);
              if (in_array($type, array(
                  "audio",
                  "video",
                  "archive",
				  "document",
				  "image",
				  ))) {
				  $where = "WHERE `type` = '$type'";	
				  $counter = Db::run()->count(false, false, "SELECT COUNT(*) FROM `" . Content::fTable . "` WHERE `type` = '$type' LIMIT 1");
              } else {
                  $where = null;
				  $counter = Db::run()->count(Content::fTable);
              }
		  } elseif (isset($_GET['letter'])) {
			  $letter = Validator::sanitize($_GET['letter'], 'default', 2);
			  $where = "WHERE `alias` REGEXP '^" . $letter . "'";
			  $counter = Db::run()->count(false, false, "SELECT COUNT(*) FROM `" . Content::fTable . "` $where LIMIT 1");
		  } else {
			  $where = null;
			  $counter = Db::run()->count(Content::fTable);
		  }

          if (isset($_GET['order']) and count(explode("|", $_GET['order'])) == 2) {
              list($sort, $order) = explode("|", $_GET['order']);
              $sort = Validator::sanitize($sort, "default", 16);
              $order = Validator::sanitize($order, "default", 4);
              if (in_array($sort, array(
                  "name",
                  "alias",
                  "filesize"))) {
                  $ord = ($order == 'DESC') ? " DESC" : " ASC";
                  $sorting = $sort . $ord;
              } else {
                  $sorting = "created DESC";
              }
          } else {
              $sorting = "created DESC";
          }
		  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = App::Core()->perpage;
          $pager->path = Url::url(Router::$path, "?");
          $pager->paginate();
		  
          $sql = "
		  SELECT * 
		  FROM `" . Content::fTable . "` 
		  $where
		  ORDER BY $sorting" . $pager->limit;
		  
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->META_T35];
          $tpl->template = 'admin/files.tpl.php';
          $tpl->title = Lang::$word->META_T35;
		  
		  $tpl->data = Db::run()->pdoQuery($sql)->results();
		  $tpl->pager = $pager;

      }
	  
      /**
       * AdminController::Help()
       * 
       * @return
       */
      public function Help()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
          $tpl->crumbs = ['admin', Lang::$word->SYS_TITLE];
		  $tpl->core = App::Core();
		  $tpl->mlist = App::Membership()->getMembershipList();
          $tpl->template = 'admin/help.tpl.php';
          $tpl->title = Lang::$word->META_T33;

      }
	  
      /**
       * Content::pageBuilder()
       * 
       * @return
       */
	  public static function pageBuilder()
	  {
	
		  $rules = array(
			  'pagename' => array('required|file|min_len,3|max_len,30', Lang::$word->HP_PNAME),
			  'header' => array('required|string', Lang::$word->HP_SUB7),
			  );

          if(!array_key_exists("membership_id", $_POST)) {
			  Message::$msgs["membership_id"] = Lang::$word->ADM_MEMBS;
		  }
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  
		  if (empty(Message::$msgs)) {
			  $mid = Utility::implodeFields($_POST["membership_id"]);

              $data = "<?php \n" 
			  . "\t/** \n" 
			  . "\t* " . $safe->pagename . "\n" 
			  . "\t*" . " \n" 
			  . "\t* @package Membership Manager Pro\n" 
			  . "\t* @author wojoscripts.com\n" 
			  . "\t* @copyright " . date('Y') . "\n" 
			  . "\t* @version Id: " . $safe->pagename . ".php, v4.0 " . date('Y-m-d H:i:s') . " gewa Exp $\n" 
			  . "\t*/\n" 
			  . " \n" 
			  . "\t define(\"_WOJO\", true); \n" 
			  . "\t require_once(\"init.php\");\n" 
			  . " \n" . "?>";

              if ($safe->header == 1) {
                  $data .= "" . " \n" 
				  . " \n" . " <?php include(FRONTBASE . \"/header.tpl.php\");?> \n" 
				  . " \n" . " \n";
              }

              $data .= "" 
			  . "\t <?php if(Membership::is_valid([$mid])): ?>\n" 
			  . " \n" 
			  . "\t <h1>User has valid membership, you can display your protected content here</h1>.\n" 
			  . " \n" . "\t <?php else: ?>\n" 
			  . " \n" . "\t <h1>User membership is't not valid. Show your custom error message here</h1>\n" 
			  . " \n" . "\t <?php endif; ?>\n" 
			  . "";

              if ($safe->header == 1) {
                  $data .= "" . " \n" 
				  . " \n" . " <?php include(FRONTBASE . \"/footer.tpl.php\");?> \n" 
				  . " \n" 
				  . " \n";
              }
			  
	          if(File::writeToFile(UPLOADS . '/' . $safe->pagename . '.php', $data)) {
				  Message::msgReply(true, 'success', Message::formatSuccessMessage($safe->pagename, Lang::$word->HP_PBUILD_OK));
			  } else {
				  Message::msgReply(true, 'error', Message::formatSuccessMessage($safe->pagename, Lang::$word->HP_PBUILD_ER));
			  }

		  } else {
			  Message::msgSingleStatus();
		  }
	  }
	  
      /**
       * AdminController::Configuration()
       * 
       * @return
       */
      public function Configuration()
      {
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
		  $tpl->data = App::Core();
		  $tpl->mlist = App::Membership()->getMembershipList();
          $tpl->template = 'admin/configuration.tpl.php';
          $tpl->title = Lang::$word->META_T25;
      }
	  
      /**
       * AdminController::Trash()
       * 
       * @return
       */
      public function Trash()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "admin/";
		  $data = Db::run()->select(Core::txTable)->results() ;
		  $tpl->data = Utility::groupToLoop($data, "type");
          $tpl->crumbs = ['admin', Lang::$word->META_T26];
          $tpl->template = 'admin/trash.tpl.php';
          $tpl->title = Lang::$word->META_T26;

      }
	  
      /**
       * AdminController::passReset()
       * 
       * @return
       */
      public function passReset()
      {
		  
          $rules = array(
              'email' => array('required|email', Lang::$word->M_EMAIL),
              'fname' => array('required|alpha', Lang::$word->M_FNAME),
              );

		  
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);

		  if(!empty($safe->email) and !empty($safe->fname)) {
			  if($row = Db::run()->first(Users::mTable, array("email", "fname", "lname", "username"), array('email =' => $safe->email, "and type <>" => "member"))) {
				  if(Validator::sanitize($row->fname) != Validator::sanitize($safe->fname)) {
					  Message::$msgs['fname'] = Lang::$word->LOGIN_R5;
					  $json['type'] = 'error';
				  }
			  } else {
				  Message::$msgs['email'] = Lang::$word->LOGIN_R5;
				  $json['type'] = 'error';
			  }
		  }
		  
          if (empty(Message::$msgs)) {
			  $row = Db::run()->first(Users::mTable, array("email", "fname", "lname", "id"), array("email = " => $safe->email, "and type <>" => "member"));
			  $salt = ''; 
			  $pass = substr(md5(uniqid(rand(), true)), 0, 10);
              $data = array(
					'hash' => App::Auth()->create_hash($pass, $salt), 
					'salt' => $salt,
			  );

			  $mailer = Mailer::sendMail();
			  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'adminPassReset'));
			  
			  $body = str_replace(array(
				  '[LOGO]',
				  '[NAME]',
				  '[DATE]',
				  '[COMPANY]',
				  '[PASSWORD]',
				  '[LINK]',
				  '[IP]',
				  '[FB]',
				  '[TW]',
				  '[SITEURL]'), array(
				  Utility::getLogo(),
				  $row->fname . ' ' . $row->lname,
				  date('Y'),
				  App::Core()->company,
				  $pass,
				  Url::url("/admin"),
				  Url::getIP(),
				  App::Core()->social->facebook,
				  App::Core()->social->twitter,
				  SITEURL), $tpl->body);
				  
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setTo(array($row->email => $row->fname . ' ' . $row->lname))
						->setFrom(array(App::Core()->site_email => App::Core()->company))
						->setBody($body, 'text/html');
					  
              Db::run()->update(Users::mTable, $data, array('id' => $row->id));
			  Message::msgReply($mailer->send($msg), 'success', Lang::$word->M_PASSWORD_RES_D);
		  } else {
			  $json['type'] = "error";
			  print json_encode($json);
		  } 
      }
  }