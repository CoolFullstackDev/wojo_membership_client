<?php
  /**
   * Front Admin
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: front.class.php, v1.00 2016-10-29 18:20:24 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');


  class FrontController
  {
	  

      /**
       * FrontController::Index()
       * 
       * @return
       */
      public function Index()
      {
		  if (App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
		  $core = App::Core();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/index.tpl.php';
          $tpl->title = str_replace("[COMPANY]", $core->company, Lang::$word->META_T28);
      }
	  
      /**
       * FrontController::Register()
       * 
       * @return
       */
      public function Register()
      {
		  if (App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
		  $core = App::Core();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/register.tpl.php';
		  $tpl->custom_fields = Content::rendertCustomFieldsFront();
		  $tpl->clist = $core->enable_tax ? App::Content()->getCountryList() : '';
          $tpl->title = str_replace("[COMPANY]", $core->company, Lang::$word->META_T28);
      }
  
      /**
       * FrontController::News()
       * 
       * @return
       */
      public function News()
      {

		  if($row = App::Content()->renderNews()) {
			  $json['type'] = "success";
			  $json['title'] = $row->title;
			  $json['content'] = $row->body;
			  $json['created'] = $row->created;
		  } else {
			  $json['title'] = "Coming Soon";
			  $json['content'] = "";
			  $json['created'] = Date::today();
			  $json['type'] = "success";
		  }
		  
		  print json_encode($json);
      }
	  
      /**
       * FrontController::Registration()
       * 
       * @return
       */
      public function Registration()
      {
		  $rules = array(
			  'fname' => array('required|string|min_len,3|max_len,60', Lang::$word->M_FNAME),
			  'lname' => array('required|string|min_len,3|max_len,60', Lang::$word->M_LNAME),
			  'password' => array('required|string|min_len,6|max_len,20', Lang::$word->M_PASSWORD),
			  'email' => array('required|email', Lang::$word->M_EMAIL),
			  'agree' => array('required|numeric', Lang::$word->PRIVACY),
			  'captcha' => array('required|numeric|exact_len,5', Lang::$word->CAPTCHA),
			  );
			  
	      if(App::Core()->enable_tax) {
			  $rules['address'] = array('required|string|min_len,3|max_len,80', Lang::$word->M_ADDRESS);
			  $rules['city'] = array('required|string|min_len,2|max_len,80', Lang::$word->M_CITY);
			  $rules['zip'] = array('required|string|min_len,3|max_len,30', Lang::$word->M_ZIP);
			  $rules['state'] = array('required|string|min_len,2|max_len,80', Lang::$word->M_STATE);
			  $rules['country'] = array('required|string|exact_len,2', Lang::$word->M_COUNTRY);
		  }


		  if (App::Session()->get('captchacode') != $_POST['captcha'])
			  Message::$msgs['captcha'] = Lang::$word->CAPTCHA;

			  
          if (!empty($_POST['email'])) {
			  if (Auth::emailExists($_POST['email'])) {
              	Message::$msgs['email'] = Lang::$word->M_EMAIL_R2;
			  }
		  }

		  $filters = array(
			  'lname' => 'trim|string',
			  'fname' => 'trim|string',
			  );
			  
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);
		  
		  Content::verifyCustomFields();
		  
          if (empty(Message::$msgs)) {
              $salt = '';
			  $hash = App::Auth()->create_hash(Validator::cleanOut($_POST['password']), $salt);
			  $username = Utility::randomString();
			  $core = App::Core();

              if ($core->reg_verify == 1) {
                  $active = "t";
              } elseif ($core->auto_verify == 0) {
                  $active = "n";
              } else {
                  $active = "y";
              }
			  
              $data = array(
                  'username' => $username,
				  'email' => $safe->email,
                  'lname' => $safe->lname,
				  'fname' => $safe->fname,
                  'hash' => $hash,
                  'salt' => $salt,
                  'type' => "member",
				  'token' => Utility::randNumbers(),
				  'active' => $active,
                  'userlevel' => 1,
				  );
				  
			  if(App::Core()->enable_tax) {
				  $data['address'] = $safe->address;
				  $data['city'] = $safe->city;
				  $data['state'] = $safe->state;
				  $data['zip'] = $safe->zip;
				  $data['country'] = $safe->country;
			  }

			  $last_id = Db::run()->insert(Users::mTable, $data)->getLastInsertId();
			  
			  // Start Custom Fields
			  $fl_array = Utility::array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if ($fl_array) {
				  $fields = Db::run()->select(Content::cfTable)->results();
				  foreach ($fields as $row) {
					  $dataArray[] = array(
						  'user_id' => $last_id,
						  'field_id' => $row->id,
						  'field_name' => $row->name,
						  );
				  }
				  Db::run()->insertBatch(Users::cfTable, $dataArray);
				  
				  foreach ($fl_array as $key => $val) {
					  $cfdata['field_value'] = Validator::sanitize($val);
					  Db::run()->update(Users::cfTable, $cfdata, array("user_id" => $last_id, "field_name" => str_replace("custom_", "", $key)));
				  }
			  }
			  
			  //Default membership
			  if($core->enable_dmembership) {
				  $row = Db::run()->first(Membership::mTable, null, array("id" => $core->dmembership));
				  $datam = array(
					  'txn_id' => "MAN_" . Utility::randomString(12),
					  'membership_id' => $row->id,
					  'user_id' => $last_id,
					  'rate_amount' => $row->price,
					  'coupon' => 0,
					  'total' => $row->price,
					  'tax' => 0,
					  'currency' => $core->currency,
					  'ip' => Url::getIP(),
					  'pp' => "MANUAL",
					  'status' => 1,
					  );
					  
					  $transid = Db::run()->insert(Membership::pTable, $datam)->getLastInsertId();
					  //insert user membership
					  $udata = array(
						  'tid' => $transid,
						  'uid' => $last_id,
						  'mid' => $row->id,
						  'expire' => Membership::calculateDays($row->id),
						  'recurring' => 0,
						  'active' => 1,
						  );
						  
					//update user record
					$xdata = array(
						'membership_id' => $row->id,
						'mem_expire' => $udata['expire'],
						);
						
					Db::run()->insert(Membership::umTable, $udata);
					Db::run()->update(Users::mTable, $xdata, array("id" => $last_id));
			  }
				  
			  if ($core->reg_verify == 1) {
				  $message = Lang::$word->M_INFO7;
				  
				  $mailer = Mailer::sendMail();
				  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'regMail'));
				  $body = str_replace(array(
					  '[LOGO]',
					  '[DATE]',
					  '[COMPANY]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[LINK]',
					  '[FB]',
					  '[TW]',
					  '[SITEURL]'), array(
					  Utility::getLogo(),
					  date('Y'),
					  $core->company,
					  $username,
					  $safe->password,
					  Url::url("/activation", '?token=' . $data['token'] . '&email=' . $data['email']),
					  $core->social->facebook,
					  $core->social->twitter,
					  SITEURL), $tpl->body);
		
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setFrom(array($core->site_email => $core->company))
						->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
						->setBody($body, 'text/html'
						);
				  $mailer->send($msg);
				  
			  } elseif ($core->auto_verify == 0) {
				  $message = Lang::$word->M_INFO7;
				  
				  $mailer = Mailer::sendMail();
				  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'regMailPending'));
				  $body = str_replace(array(
					  '[LOGO]',
					  '[DATE]',
					  '[COMPANY]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[FB]',
					  '[TW]',
					  '[SITEURL]'), array(
					  Utility::getLogo(),
					  date('Y'),
					  $core->company,
					  $username,
					  $safe->password,
					  $core->social->facebook,
					  $core->social->twitter,
					  SITEURL), $tpl->body);
		
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setFrom(array($core->site_email => $core->company))
						->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
						->setBody($body, 'text/html'
						);
				  $mailer->send($msg);
			  } else {
				  //login user
				  App::Auth()->login($safe->email, $safe->password);
				  $message = Lang::$word->M_INFO8;
				  
				  $mailer = Mailer::sendMail();
				  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'welcomeEmail'));
				  $body = str_replace(array(
					  '[LOGO]',
					  '[DATE]',
					  '[LINK]',
					  '[COMPANY]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[FB]',
					  '[TW]',
					  '[SITEURL]'), array(
					  Utility::getLogo(),
					  date('Y'),
					  Url::url(""),
					  $core->company,
					  $username,
					  $safe->password,
					  $core->social->facebook,
					  $core->social->twitter,
					  SITEURL), $tpl->body);
		
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setFrom(array($core->site_email => $core->company))
						->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
						->setBody($body, 'text/html'
						);
				  $mailer->send($msg);
			  }
			  
			  if ($core->notify_admin) {
				  $mailer = Mailer::sendMail();
				  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'notifyAdmin'));
				  $body = str_replace(array(
					  '[LOGO]',
					  '[DATE]',
					  '[EMAIL]',
					  '[COMPANY]',
					  '[USERNAME]',
					  '[NAME]',
					  '[IP]',
					  '[FB]',
					  '[TW]',
					  '[SITEURL]'), array(
					  Utility::getLogo(),
					  date('Y'),
					  $safe->email,
					  $core->company,
					  $username,
					  $data['fname'] . ' ' . $data['lname'],
					  Url::getIP(),
					  $core->social->facebook,
					  $core->social->twitter,
					  SITEURL), $tpl->body);
		
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setFrom(array($core->site_email => $core->company))
						->setTo(array($core->site_email => $core->company))
						->setBody($body, 'text/html'
						);
				  $mailer->send($msg);
			  }
			  
              if (Db::run()->affected() && $mailer) {
				  $json['type'] = 'success';
				  $json['title'] = Lang::$word->SUCCESS;
				  $json['redirect'] = SITEURL;
				  $json['message'] = $message;
				  print json_encode($json);
			  } else {
				  $json['type'] = 'error';
				  $json['title'] = Lang::$word->ERROR;
				  $json['message'] = Lang::$word->M_INFO11;
				  print json_encode($json);
			  }
				  
		  } else {
			  Message::msgSingleStatus();
		  }
	  }
	  
      /**
       * FrontController::Dashboard()
       * 
       * @return
       */
      public function Dashboard()
      {
		  if (!App::Auth()->is_User()) {
			  Url::redirect(SITEURL); 
			  exit; 
		  }
		  $core = App::Core();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
		  $tpl->data = Db::run()->select(Membership::mTable, null, array("private" => 0, "active" => 1), "ORDER BY price")->results();
          $tpl->template = 'front/dashboard.tpl.php';
          $tpl->title = str_replace("[COMPANY]", $core->company, Lang::$word->META_T28);
      }

      /**
       * FrontController::Activation()
       * 
       * @return
       */
      public function Activation()
      {

		  $core = App::Core();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/activation.tpl.php';
          $tpl->title = str_replace("[COMPANY]", $core->company, Lang::$word->META_T28);
		  
		  if(Validator::get('token') and Validator::get('email')) {
			  $rules = array(
				  'email' => array('required|email', Lang::$word->M_EMAIL),
				  'token' => array('required|numeric|min_len,5|max_len,12', Lang::$word->M_INFO10),
				  );
			  $filters = array('token' => 'string');
			  
			  $validate = Validator::instance();
			  $safe = $validate->doValidate($_GET, $rules);
			  $safe = $validate->doFilter($_GET, $filters);
			  
			  if (empty(Message::$msgs)) {
				  if ($row = Db::run()->first(Users::mTable, array("id"), array(
					  "email" => $safe->email,
					  "token" => $safe->token,
					  ))) {
					  Db::run()->update(Users::mTable, array("active" => "y", "token" => 0), array("id" => $row->id));
					  Url::redirect(Url::url("/activation","?done=true"));
				  } else {
					  Url::url("/activation","?error=true");
				  }
			  } else {
				  Url::url("/activation","?error=true");
			  }
		  } else {
			  Url::url("/activation","?error=true");
		  }
      }

      /**
       * FrontController::Packages()
       * 
       * @return
       */
      public function Packages()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
		  $tpl->data = Db::run()->select(Membership::mTable, null, array("private" => 0, "active" => 1), "ORDER BY price")->results();
          $tpl->template = 'front/packages.tpl.php';
          $tpl->title = Lang::$word->META_T29;
      }

      /**
       * FrontController::History()
       * 
       * @return
       */
      public function History()
      {
		  if (!App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
		  $tpl->data = Stats::userHistory(App::Auth()->uid, 'expire');
		  $tpl->totals = Stats::userTotals();
          $tpl->template = 'front/history.tpl.php';
          $tpl->title = Lang::$word->META_T31;
      }

      /**
       * FrontController::Downloads()
       * 
       * @return
       */
      public function Downloads()
      {
		  if (!App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/downloads.tpl.php';
		  $tpl->data = Db::run()->pdoQuery("SELECT * FROM  `" . Content::fTable . "` WHERE FIND_IN_SET(" . App::Auth()->membership_id . ", fileaccess) ORDER BY created DESC")->results();
          $tpl->title = Lang::$word->META_T34;
      }
	  
      /**
       * FrontController::Validate()
       * 
       * @return
       */
      public function Validate()
      {
		  if (!App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
		  $core = App::Core();
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/validate.tpl.php';
          $tpl->title = str_replace("[COMPANY]", $core->company, Lang::$word->META_T28);
      }
	  
      /**
       * FrontController::Profile()
       * 
       * @return
       */
      public function Profile()
      {
		  if (!App::Auth()->is_User()) {
			  Url::redirect(URL::url('/dashboard')); 
			  exit; 
		  }
          $row = Db::run()->first(Users::mTable, null, array('id' => App::Auth()->uid));
          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
		  $tpl->data = $row;
		  $tpl->clist = App::Content()->getCountryList();
		  $tpl->custom_fields = Content::rendertCustomFields(App::Auth()->uid);
          $tpl->template = 'front/profile.tpl.php';
          $tpl->title = Lang::$word->META_T32;
      }

      /**
       * FrontController::updateProfile()
       * 
       * @return
       */
	  public function updateProfile()
	  {
		  $rules = array(
			  'fname' => array('required|string|min_len,3|max_len,60', Lang::$word->M_FNAME),
			  'lname' => array('required|string|min_len,3|max_len,60', Lang::$word->M_LNAME),
			  'email' => array('required|email', Lang::$word->M_EMAIL),
			  'newsletter' => array('required|numeric|exact_len,1', Lang::$word->M_SUB10),
			  );
	
		  if (App::Core()->enable_tax) {
			  $rules['address'] = array('required|string|min_len,3|max_len,80', Lang::$word->M_ADDRESS);
			  $rules['city'] = array('required|string|min_len,2|max_len,80', Lang::$word->M_CITY);
			  $rules['zip'] = array('required|string|min_len,3|max_len,30', Lang::$word->M_ZIP);
			  $rules['state'] = array('required|string|min_len,2|max_len,80', Lang::$word->M_STATE);
			  $rules['country'] = array('required|string|exact_len,2', Lang::$word->M_COUNTRY);
		  }
	
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
	
		  Content::verifyCustomFields();
		  
		  $upl = Upload::instance(512000, "png,jpg");
		  if (!empty($_FILES['avatar']['name']) and empty(Message::$msgs)) {
			  $upl->process("avatar", UPLOADS . "/avatars/", "AVT_");
		  }
		  
		  if (empty(Message::$msgs)) {
			  $data = array(
				  'email' => $safe->email,
				  'lname' => $safe->lname,
				  'fname' => $safe->fname,
				  'newsletter' => $safe->newsletter,
				  );
			  if (App::Core()->enable_tax) {
				  $data['address'] = $safe->address;
				  $data['city'] = $safe->city;
				  $data['zip'] = $safe->zip;
				  $data['state'] = $safe->state;
				  $data['country'] = $safe->country;
			  }
	
			  if (!empty($_POST['password'])) {
				  $salt = '';
				  $hash = App::Auth()->create_hash(Validator::cleanOut($_POST['password']), $salt);
				  $data['hash'] = $hash;
				  $data['salt'] = $salt;
			  }
	
			  if (isset($upl->fileInfo['fname'])) {
				  $data['avatar'] = $upl->fileInfo['fname'];
				  if (Auth::$udata->avatar != "") {
					  File::deleteFile(UPLOADS . "/avatars/" . Auth::$udata->avatar);
					  Auth::$udata->avatar = App::Session()->set('avatar', $upl->fileInfo['fname']);
				  }
			  }
	
			  // Start Custom Fields
			  $fl_array = Utility::array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if ($fl_array) {
				  $result = array();
				  foreach ($fl_array as $key => $val) {
					$cfdata['field_value'] = Validator::sanitize($val);
					Db::run()->update(Users::cfTable, $cfdata, array("user_id" => Auth::$udata->uid, "field_name" => str_replace("custom_", "", $key)));
				  }
			  }
	
			  Db::run()->update(Users::mTable, $data, array("id" => Auth::$udata->uid));
			  Message::msgReply(Db::run()->affected(), 'success', str_replace("[NAME]", "", Lang::$word->M_UPDATED));
			  if(Db::run()->affected()) {
				  Auth::$udata->email = App::Session()->set('email', $data['email']);
				  Auth::$udata->fname = App::Session()->set('fname', $data['fname']);
				  Auth::$udata->lname = App::Session()->set('lname', $data['lname']);
				  Auth::$udata->name = App::Session()->set('name', $data['fname'] . ' ' . $data['lname']);
				  if (App::Core()->enable_tax) {
					  Auth::$udata->country = App::Session()->set('country', $data['country']);
				  }
			  }
		  } else {
			  Message::msgSingleStatus();
		  }
	  }
	  
      /**
       * FrontController::Contact()
       * 
       * @return
       */
      public function Contact()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/contact.tpl.php';
          $tpl->title = Lang::$word->META_T30;
      }

      /**
       * FrontController::processContact()
       * 
       * @return
       */
      public function processContact()
      {
		  $rules = array(
			  'name' => array('required|string|min_len,3|max_len,60', Lang::$word->CNT_NAME),
			  'notes' => array('required|string|min_len,3|max_len,400', Lang::$word->MESSAGE),
			  'email' => array('required|email', Lang::$word->M_EMAIL),
			  'captcha' => array('required|numeric|exact_len,5', Lang::$word->CAPTCHA),
			  );

		  $filters = array(
			  'subject' => 'trim|string',
			  );
			  
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);
		  
          if (empty(Message::$msgs)) {
			  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'contact'));
			  $mailer = Mailer::sendMail();
			  $core = App::Core();

			  $body = str_replace(array(
				  '[LOGO]',
				  '[EMAIL]',
				  '[NAME]',
				  '[MAILSUBJECT]',
				  '[MESSAGE]',
				  '[IP]',
				  '[DATE]',
				  '[COMPANY]',
				  '[FB]',
				  '[TW]',
				  '[SITEURL]'), array(
				  Utility::getLogo(),
				  $safe->email,
				  $safe->name,
				  $safe->subject,
				  $safe->notes,
				  Url::getIP(),
				  date('Y'),
				  $core->company,
				  $core->social->facebook,
				  $core->social->twitter,
				  SITEURL), $tpl->body);
	
			  $msg = Swift_Message::newInstance()
					->setSubject($tpl->subject)
					->setFrom(array($safe->email => $safe->name))
					->setTo(array($core->site_email => $core->company))
					->setBody($body, 'text/html'
					);

              if ($mailer->send($msg)) {
				  $json['type'] = 'success';
				  $json['title'] = Lang::$word->SUCCESS;
				  $json['redirect'] = Url::url('/contact');
				  $json['message'] = Lang::$word->CNT_OK;
				  print json_encode($json);
			  } else {
				  $json['type'] = 'error';
				  $json['title'] = Lang::$word->ERROR;
				  $json['message'] = Lang::$word->M_INFO11;
				  print json_encode($json);
			  }
			  
		  } else {
			  Message::msgSingleStatus();
		  }
	  }

      /**
       * FrontController::Privacy()
       * 
       * @return
       */
      public function Privacy()
      {

          $tpl = App::View(BASEPATH . 'view/');
          $tpl->dir = "front/";
          $tpl->template = 'front/privacy.tpl.php';
          $tpl->title = Lang::$word->META_T36;
      }
	  
      /**
       * FrontController::passReset()
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
			  if($row = Db::run()->first(Users::mTable, array("email", "fname", "lname", "username"), array('email' => $safe->email, "type" => "member", "active" => "y"))) {
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
			  $row = Db::run()->first(Users::mTable, array("email", "fname", "lname", "id"), array("email" => $safe->email, "type" => "member", "active" => "y"));
			  $salt = ''; 
			  $pass = substr(md5(uniqid(rand(), true)), 0, 10);
              $data = array(
					'hash' => App::Auth()->create_hash($pass, $salt), 
					'salt' => $salt,
			  );

			  $mailer = Mailer::sendMail();
			  $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'userPassReset'));
			  
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
				  SITEURL,
				  Url::getIP(),
				  App::Core()->social->facebook,
				  App::Core()->social->twitter,
				  SITEURL), $tpl->body);
				  
				  $msg = Swift_Message::newInstance()
						->setSubject($tpl->subject)
						->setFrom(array(App::Core()->site_email => App::Core()->company))
						->setTo(array($row->email => $row->fname . ' ' . $row->lname))
						->setBody($body, 'text/html');
					  
              Db::run()->update(Users::mTable, $data, array('id' => $row->id));
			  Message::msgReply($mailer->send($msg), 'success', Lang::$word->M_PASSWORD_RES_D);
		  } else {
			  $json['type'] = "error";
			  print json_encode($json);
		  } 
      }
	  
      /**
       * FrontController::buyMembership()
       * 
       * @return
       */
      public function buyMembership()
      {
		  
		  if($row = Db::run()->first(Membership::mTable, null, array("id" => Filter::$id, "private" => 0))) {
			  $gaterows = Db::run()->select(AdminController::gTable, null, array("active" => 1))->results();
			  
			  if ($row->price == 0)  {
				  $data = array(
					  'membership_id' => $row->id,
					  'mem_expire' => Membership::calculateDays($row->id),
					  );
	
				  Db::run()->update(Users::mTable, $data, array("id" => App::Auth()->uid));
				  Auth::$udata->membership_id = App::Session()->set('membership_id', $row->id);
				  Auth::$udata->mem_expire = App::Session()->set('mem_expire', $data['mem_expire']);
				  
				  $json['message'] = Message::msgSingleOk(str_replace("[NAME]", $row->title, Lang::$word->M_INFO12), false);
			  } else {
				  $recurring = ($row->recurring) ? Lang::$word->YES : Lang::$word->NO;
				  Db::run()->delete(Membership::cTable, array("uid" => App::Auth()->uid));
				  $tax = Membership::calculateTax();
				  
				  $data = array(
					  'uid' => App::Auth()->uid,
					  'mid' => $row->id,
					  'originalprice' => $row->price,
					  'tax' => Validator::sanitize($tax, "float"),
					  'totaltax' => Validator::sanitize($row->price * $tax, "float"),
					  'total' => $row->price,
					  'totalprice' => Validator::sanitize($tax * $row->price + $row->price, "float"),
					  );
				  Db::run()->insert(Membership::cTable, $data);
				  $cart = Membership::getCart();
				  
				  $tpl = App::View(BASEPATH . 'view/front/snippets/'); 
				  $tpl->row = $row;
				  $tpl->gateways = $gaterows;
				  $tpl->cart = $cart;
				  $tpl->template = 'loadSummary.tpl.php'; 
				  $json['message'] = $tpl->render();
			  }
		  } else {
			  $json['type'] = "error";
		  }
		  print json_encode($json);
      }
	  
      /**
       * FrontController::selectGateway()
       * 
       * @return
       */
	  public function selectGateway()
	  {
	
		  if ($cart = Membership::getCart()) {
			  $gateway = Db::run()->first(AdminController::gTable, null, array("id" => Filter::$id, "active" => 1));
			  $row = Db::run()->first(Membership::mTable, null, array("id" => $cart->mid));
			  $tpl = App::View(BASEPATH . 'gateways/' . $gateway->dir . '/');
			  $tpl->cart = $cart;
			  $tpl->gateway = $gateway;
			  $tpl->row = $row;
			  $tpl->template = 'form.tpl.php';
			  $json['message'] = $tpl->render();
		  } else {
			  $json['message'] = Message::msgSingleError(Lang::$word->SYSERROR, false);
		  }
		  print json_encode($json);
	  }
	  
      /**
       * FrontController::getCoupon()
       * 
       * @return
       */
	  public function getCoupon()
	  {
	      $sql = "SELECT * FROM `" . Content::dcTable . "` WHERE FIND_IN_SET(" . Filter::$id . ", membership_id) AND code = ? AND active = ?";
		  if ($row = Db::run()->pdoQuery($sql, array(Validator::sanitize($_POST['code']), 1))->result()) {
			  $row2 = Db::run()->first(Membership::mTable, null, array("id" => Filter::$id));
			  
			  Db::run()->delete(Membership::cTable, array("uid" => App::Auth()->uid));
			  $tax = Membership::calculateTax();
			  
			  if($row->type == "p") {
				  $disc = Validator::sanitize($row2->price / 100 * $row->discount, "float");
				  $gtotal = Validator::sanitize($row2->price - $disc, "float");
			  } else {
				  $disc = Validator::sanitize($row->discount, "float");
				  $gtotal = Validator::sanitize($row2->price - $disc, "float");
			  }

			  $data = array(
				  'uid' => App::Auth()->uid,
				  'mid' => $row2->id,
				  'cid' => $row->id,
				  'tax' => Validator::sanitize($tax, "float"),
				  'totaltax' => Validator::sanitize($gtotal * $tax, "float"),
				  'coupon' => $disc,
				  'total' => $gtotal,
				  'originalprice' => $row2->price,
				  'totalprice' => Validator::sanitize($tax * $gtotal + $gtotal, "float"),
				  );
			  Db::run()->insert(Membership::cTable, $data);
		  
			  $json['type'] = "success";
			  $json['disc'] = "- " . Utility::formatMoney($disc);
			  $json['tax'] = Utility::formatMoney($data['totaltax']);
			  $json['gtotal'] = Utility::formatMoney($data['totalprice']);
		  } else {
			  $json['type'] = "error";
		  }
		  print json_encode($json);
	  }
  }