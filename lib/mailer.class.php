<?php
  /**
   * Mailer Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: mailer.class.php, v1.00 2016-06-05 10:12:05 gewa Exp $
   */
  
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class Mailer
  {
	  
	  private static $instance;

      /**
       * Mailer::__construct()
       * 
       * @return
       */
      private function __construct(){}

      /**
       * Mailer::instance()
       * 
       * @return
       */
	  public static function instance(){
		  if (!self::$instance){ 
			  self::$instance = new Mailer(); 
		  } 
	  
		  return self::$instance;  
	  }

      /**
       * Mailer::sendMail()
       * 
       * @return
       */
      public static function sendMail()
      {
          require_once (BASEPATH . 'lib/swift/swift_required.php');
          
		  $core = App::Core();
          if ($core->mailer == "SMTP") {
			  $SSL = ($core->is_ssl) ? 'ssl' : null;
              $transport = Swift_SmtpTransport::newInstance($core->smtp_host, $core->smtp_port, $SSL)
						  ->setUsername($core->smtp_user)
						  ->setPassword($core->smtp_pass);
		  } elseif ($core->mailer == "SMAIL") {
			  $transport = Swift_SendmailTransport::newInstance($core->sendmail);
          } else
              $transport = Swift_MailTransport::newInstance();
          
          return Swift_Mailer::newInstance($transport);
	  }
  }