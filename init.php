<?php
  /**
   * Init
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: init.php, v1.00 2016-03-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  $BASEPATH = str_replace("init.php", "", realpath(__FILE__));
  define("BASEPATH", $BASEPATH);
  
  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once($configFile);
  } else {
      header("Location: setup/");
	  exit;
  }

  require_once (BASEPATH . "bootstrap.php");
  Bootstrap::init();
  wError::run();
  Filter::run();
  Debug::run();
  new Lang();


  define("ADMIN", BASEPATH . "admin/");
  define("FRONT", BASEPATH . "front/");
  
  $dir = (App::Core()->site_dir) ? '/' . App::Core()->site_dir : '';
  $url = preg_replace("#/+#", "/", $_SERVER['HTTP_HOST'] . $dir);
  $site_url = Url::protocol() . "://" . $url;
  
  define("SITEURL", $site_url);
  define("UPLOADURL", SITEURL . '/uploads');
  define("UPLOADS", BASEPATH . 'uploads');
  
  define("ADMINURL", SITEURL . '/admin');
  define("ADMINVIEW", SITEURL . '/view/admin');
  define("ADMINBASE", BASEPATH . 'view/admin');
  
  define("FRONTVIEW", SITEURL . '/view/front');
  define("FRONTBASE", BASEPATH . 'view/front');