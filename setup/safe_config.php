<?php
  /**
   * Safe Configuration
   *
   * @package Freelance Manager
   * @author wojoscripts.com
   * @copyright 2014
   * @version $Id: safe_config.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
?>
<?php
  $host = $_GET['h'];
  $username = $_GET['u'];
  $password = $_GET['p'];
  $name = $_GET['n'];
  $key = $_GET['k'];
  
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=config.ini.php");

          $content = "<?php \n" 
		  . "\t/** \n" 
		  . "\t* Configuration\n"
		  . "\n"
		  . "\t* @package Wojo Framework\n"
		  . "\t* @author wojoscripts.com\n"
		  . "\t* @copyright " . date('Y') . "\n"
		  . "\t* @version Id: config.ini.php, v1.00 " . date('Y-m-d h:i:s') . " gewa Exp $\n"
		  . "\t*/\n"

		  . " \n" 
		  . "\t if (!defined(\"_WOJO\")) \n"
		  . "     die('Direct access to this location is not allowed.');\n"
		  
		  . " \n" 
		  . "\t/** \n" 
		  . "\t* Database Constants - these constants refer to \n"
		  . "\t* the database configuration settings. \n"
		  . "\t*/\n"
		  . "\t define('DB_SERVER', '".$host."'); \n" 
		  . "\t define('DB_USER', '".$username."'); \n"  
		  . "\t define('DB_PASS', '".$password."'); \n"  
		  . "\t define('DB_DATABASE', '" . $name . "');\n" 
		  . "\t define('DB_DRIVER', 'mysql');\n"

		  . " \n" 
		  . "\t define('INSTALL_KEY', '".$key."'); \n"
		  
		  . " \n" 
		  . "\t/** \n" 
		  . "\t* Show Debugger Console. \n"
		  . "\t* Display errors in console view. Not recomended for live site. true/false \n"
		  . "\t*/\n"
		  . "\t define('DEBUG', false);\n"
		  . "?>";

echo $content;
?>