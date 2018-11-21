<?php
  /**
   * Index
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: index.php, v1.00 2016-01-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
?>
<?php
  if (!file_exists("../lib/config.ini.php")) {
      if (file_exists("setup.php")) {
          header("Location: setup.php");
      } else {
          die("<div style='text-align:center'>" 
			  . "<span style='padding: 5px; border: 1px solid #999; background-color:#EFEFEF;" 
			  . "font-family: Verdana; font-size: 11px; margin-left:auto; margin-right:auto; display:inline-block'>" 
			  . "<b>Attention:</b>The configuration file is missing and a new installation cannot be started because the install file cannot be located</span></div>");
      }
  } elseif (file_exists("update.php")) {
      header("Location: update.php");
  } else {
      die("<div style='text-align:center'>" 
		  . "<span style='padding: 20px; border: 1px solid #999; background-color:#EFEFEF;" 
		  . "font-family: Verdana; font-size: 11px; margin-left:auto; margin-right:auto; display:inline-block'>" 
		  . "<b>Attention:</b> The file config.ini.php already exists!<br>If you want to reinstall Membership Manager you must first delete the config.ini.php located in /lib/ folder</span></div>");
  }
?>