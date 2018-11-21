<?php
  /**
   * Core Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: core.class.php, v1.00 2016-06-05 10:12:05 gewa Exp $
   */

  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class Core
  {

      const sTable = "settings";
	  const txTable = "trash";
      public static $language;

      public $_url;
      public $_urlParts;

      /**
       * Core::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $this->getSettings();
          ($this->dtz) ? ini_set('date.timezone', $this->dtz) : date_default_timezone_set('UTC');
		  Locale::setDefault($this->locale);
      }

      /**
       * Core::getSettings()
       * 
       * @return
       */
      private function getSettings()
      {
          $row = Db::run()->select(self::sTable, null, array('id' => 1))->result();

          $this->company = $row->company;
          $this->site_dir = $row->site_dir;
          $this->site_email = $row->site_email;
		  $this->psite_email = $row->psite_email;
          $this->logo = $row->logo;
		  $this->plogo = $row->plogo;
          $this->short_date = $row->short_date;
          $this->long_date = $row->long_date;
          $this->time_format = $row->time_format;
          $this->dtz = $row->dtz;
          $this->locale = $row->locale;
          $this->lang = $row->lang;
          $this->weekstart = $row->weekstart;
		  $this->perpage = $row->perpage;
		  $this->currency = $row->currency;
		  $this->enable_tax = $row->enable_tax;
		  $this->inv_info = $row->inv_info;
		  $this->inv_note = $row->inv_note;
		  $this->offline_info = $row->offline_info;
		  $this->reg_allowed = $row->reg_allowed;
		  $this->reg_verify = $row->reg_verify;
		  $this->notify_admin = $row->notify_admin;
		  $this->auto_verify = $row->auto_verify;
		  $this->social = json_decode($row->social_media);
          $this->mailer = $row->mailer;
		  $this->file_dir = $row->file_dir;
		  
		  $this->enable_dmembership = $row->enable_dmembership;
		  $this->dmembership = $row->dmembership;
		  
          $this->smtp_host = $row->smtp_host;
          $this->smtp_user = $row->smtp_user;
          $this->smtp_pass = $row->smtp_pass;
          $this->smtp_port = $row->smtp_port;
          $this->sendmail = $row->sendmail;
          $this->is_ssl = $row->is_ssl;
		  $this->backup = $row->backup;
          $this->wojov = $row->wojov;
          $this->wojon = $row->wojon;

      }

      /**
       * Core::processConfig()
       * 
       * @return
       */
      public function processConfig()
      {

		  $rules = array(
			  'company' => array('required|string|min_len,2|max_len,50', Lang::$word->CG_SITENAME),
			  'site_email' => array('required|email|min_len,3|max_len,100', Lang::$word->CG_WEBEMAIL),
			  'long_date' => array('required|string', Lang::$word->CG_LONGDATE),
			  'short_date' => array('required|string', Lang::$word->CG_SHORTDATE),
			  'time_format' => array('required|string', Lang::$word->CG_TIMEFORMAT),
			  'weekstart' => array('required|numeric', Lang::$word->CG_WEEKSTART),
			  'lang' => array('required|string|min_len,2|max_len,2', Lang::$word->CG_LANG),
			  'perpage' => array('required|numeric', Lang::$word->CG_PERPAGE),
			  'dtz' => array('required|string', Lang::$word->CG_DTZ),
			  'locale' => array('required|string', Lang::$word->CG_LOCALES),
			  'reg_verify' => array('required|numeric', Lang::$word->CG_REGVERIFY),
			  'auto_verify' => array('required|numeric', Lang::$word->CG_AUTOVERIFY),
			  'reg_allowed' => array('required|numeric', Lang::$word->CG_REGALOWED),
			  'notify_admin' => array('required|numeric', Lang::$word->CG_NOTIFY_ADMIN),
			  'currency' => array('required|string|min_len,3|max_len,6', Lang::$word->CG_CURRENCY),
			  'enable_tax' => array('required|numeric', Lang::$word->CG_ETAX),
			  'mailer' => array('required|string|min_len,3|max_len,5', Lang::$word->CG_MAILER),
			  'is_ssl' => array('required|numeric', Lang::$word->CG_SMTP_SSL),
			  'file_dir' => array('required|string', Lang::$word->CG_FILEDIR),
			  );
	
		  $filters = array(
		      'psite_email' => 'string',
			  'twitter' => 'string',
			  'facebook' => 'string',
			  'inv_info' => 'basic_tags',
			  'inv_note' => 'basic_tags',
			  'inv_note' => 'basic_tags',
			  'dmembership' => 'numbers',
			  );

  		switch ($_POST['mailer']) {
  			case "SMTP":
  				$rules['smtp_host'] = ['required|string', Lang::$word->CG_SMTP_HOST];
				$rules['smtp_user'] = ['required|string', Lang::$word->CG_SMTP_USER];
				$rules['smtp_pass'] = ['required|string', Lang::$word->CG_SMTP_PASS];
				$rules['smtp_port'] = ['required|numeric', Lang::$word->CG_SMTP_PORT];
  				break;

  			case "SMAIL":
  				$rules['sendmail'] = ['required|string', Lang::$word->CG_SMAILPATH];
  				break;
  		}
		
		  $validate = Validator::instance();
		  $safe = $validate->doValidate($_POST, $rules);
		  $safe = $validate->doFilter($_POST, $filters);

		  if (!empty($_FILES['logo']['name']) and empty(Message::$msgs)) {
			  $upl = Upload::instance(3145728, "png,jpg");
			  $upl->process("logo", UPLOADS . "/", false, "logo", false);
		  }

		  if (!empty($_FILES['plogo']['name']) and empty(Message::$msgs)) {
			  $upl = Upload::instance(3145728, "png,jpg");
			  $upl->process("plogo", UPLOADS . "/", false, "print_logo", false);
		  }
		  
		  if (empty(Message::$msgs)) {
			  $smedia['facebook'] = $safe->facebook;
			  $smedia['twitter'] = $safe->twitter;
			  
			  $data = array(
				  'company' => $safe->company,
				  'site_email' => $safe->site_email,
				  'psite_email' => $safe->psite_email,
				  'long_date' => $safe->long_date,
				  'short_date' => $safe->short_date,
				  'time_format' => $safe->time_format,
				  'weekstart' => $safe->weekstart,
				  'lang' => $safe->lang,
				  'perpage' => $safe->perpage,
				  'dtz' => $safe->dtz,
				  'locale' => $safe->locale,
				  'reg_verify' => $safe->reg_verify,
				  'auto_verify' => $safe->auto_verify,
				  'reg_allowed' => $safe->reg_allowed,
				  'notify_admin' => $safe->notify_admin,
				  'currency' => $safe->currency,
				  'enable_tax' => $safe->enable_tax,
				  'social_media' => json_encode($smedia),
				  'mailer' => $safe->mailer,
				  'sendmail' => $safe->sendmail,
				  'smtp_host' => $safe->smtp_host,
				  'smtp_user' => $safe->smtp_user,
				  'smtp_pass' => $safe->smtp_pass,
				  'smtp_port' => $safe->smtp_port,
				  'is_ssl' => $safe->is_ssl,
				  'file_dir' => $safe->file_dir,
				  'enable_dmembership' => empty($_POST['enable_dmembership']) ? 0 : 1,
				  'dmembership' => $safe->dmembership,
				  'inv_info' => $safe->inv_info,
				  'inv_note' => $safe->inv_note,
				  'offline_info' => $safe->offline_info,
				  );

			  if (!empty($_FILES['logo']['name'])) {
				  $data['logo'] = $upl->fileInfo['fname'];
			  }
			  
			  if (!empty($_FILES['plogo']['name'])) {
				  $data['plogo'] = $upl->fileInfo['fname'];
			  }
			  
			  if (Validator::post('dellogo')) {
				  $data['logo'] = "NULL";
			  }
			  if (Validator::post('dellogop')) {
				  $data['plogo'] = "NULL";
			  }
			  
			  Db::run()->update(self::sTable, $data, array('id' => 1));
			  Message::msgReply(Db::run()->affected(), 'success', Lang::$word->CG_UPDATED);
		  } else {
			  Message::msgSingleStatus();
		  }
      }
	  
      /**
       * Core::restoreFromTrash()
       *
       * @return
       */
      public static function restoreFromTrash($array, $table)
      {
          if ($array) {
              $mapped = array_map(function($k) {
				  return "`".$k."` = ?";
				  },array_keys((array)$array
				  ));
              $stmt = Db::run()->prepare("INSERT INTO `" . $table . "` SET ".implode(", ",$mapped));
              $stmt->execute(array_values((array)$array));
			  
              $json['type'] = "success";
              print json_encode($json);
          }
      }
  }
