<?php 
	/** 
	* Configuration

	* @package Wojo Framework
	* @author wojoscripts.com
	* @copyright 2018
	* @version Id: config.ini.php, v1.00 2018-11-21 10:14:32 gewa Exp $
	*/
 
	 if (!defined("_WOJO")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', ''); 
	 define('DB_DATABASE', 'clientarea');
	 define('DB_DRIVER', 'mysql');
 
	 define('INSTALL_KEY', 'T5QMiixSSFt5PADD'); 
 
	/** 
	* Show Debugger Console. 
	* Display errors in console view. Not recomended for live site. true/false 
	*/
	 define('DEBUG', false);
?>