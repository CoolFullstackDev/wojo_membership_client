<?php
  /**
   * Functions
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: functions.php, v1.00 2016-01-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  /**
   * sanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false)
  {
	$string = filter_var($string, FILTER_SANITIZE_STRING); 
	$string = trim($string);
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = str_replace(array('‘','’','“','”'), array("'","'",'"','"'), $string);
	if($trim)
	$string = substr($string, 0, $trim);
	
	return $string;
  }
  
  /**
   * getIniSettings()
   * 
   * @param mixed $aSetting
   * @return
   */
  function getIniSettings($aSetting)
  {
	  $out = (ini_get($aSetting) == '1' ? 'ON' : 'OFF');
	  return $out;
  }

  /**
   * sessionKey()
   * 
   * @return
   */
  function sessionKey()
  {
	  return substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 16)), 0, 16);
  }
  
  /**
   * getWritableCell()
   * 
   * @param mixed $aDir
   * @return
   */
  function getWritableCell($aDir)
  {
	  echo '<tr>';
	  echo '<td>'.$aDir .CMS_DS.'</td>';
	  echo '<td>';
	  echo is_writable(DDPBASE.$aDir) ? '<span class="yes">Writeable</span>' : '<span class="no">Unwriteable</span>';
	  echo '</td>';
	  echo '</tr>';
  }

  /**
   * removeComments()
   * 
   * @param mixed $query
   * @return
   */
  function removeComments($query)
  {
	  /*
	   * Commented version
	   * $sqlComments = '@
	   * (([\'"]).*?[^\\\]\2) # $1 : Skip single & double quoted expressions
	   * |( # $3 : Match comments
	   * (?:\#|--).*?$ # - Single line comments
	   * | # - Multi line (nested) comments
	   * /\* # . comment open marker
	   * (?: [^/*] # . non comment-marker characters
	   * |/(?!\*) # . ! not a comment open
	   * |\*(?!/) # . ! not a comment close
	   * |(?R) # . recursive case
	   * )* # . repeat eventually
	   * \*\/ # . comment close marker
	   * )\s* # Trim after comments
	   * |(?<=;)\s+ # Trim after semi-colon
	   * @msx';
	   */
	  $sqlComments = '@(([\'"]).*?[^\\\]\2)|((?:\#|--).*?$|/\*(?:[^/*]|/(?!\*)|\*(?!/)|(?R))*\*\/)\s*|(?<=;)\s+@ms';
					 
	  $query = trim( preg_replace( $sqlComments, '$1', $query ) );
	 
	  //Eventually remove the last ;
	  if(strrpos($query, ";") === strlen($query) - 1) {
		  $query = substr($query, 0, strlen($query) - 1);
	  }
	 
	  return $query;
  }

  /**
   * parse()
   * 
   * @param mixed $content
   * @return
   */
  function parse($content) 
  {

	  $sqlList = array();
	 
	  // Processing the SQL file content
	  $lines = explode("\n", $content);

	  $query = "";
	 
	  // Parsing the SQL file content
	  foreach ($lines as $sql_line):
		  $sql_line = trim($sql_line);
		  if($sql_line === "") continue;
		  else if(strpos($sql_line, "--") === 0) continue;
		  else if(strpos($sql_line, "#") === 0) continue;
			 
		  $query .= $sql_line;
		  if (preg_match("/(.*);/", $sql_line)) {
			  $query = trim($query);
			  $query = substr($query, 0, strlen($query) - 1);
			  //$query = removeComments($query);
			  $sqlList[] = $query;
			  $query = "";
		  }
		 
	  endforeach;

	  return $sqlList;
  }
	
  /**
   * writeConfigFile()
   * 
   * @param mixed $param
   * @param bool $safe
   * @return
   */
  function writeConfigFile($param, $safe = false)
  {
      
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
		  . "\t define('DB_SERVER', '".$param['host']."'); \n" 
		  . "\t define('DB_USER', '".$param['user']."'); \n"  
		  . "\t define('DB_PASS', '".$param['pass']."'); \n"  
		  . "\t define('DB_DATABASE', '" . $param['name'] . "');\n" 
		  . "\t define('DB_DRIVER', 'mysql');\n"

		  . " \n" 
		  . "\t define('INSTALL_KEY', '".$param['key']."'); \n"
		  
		  . " \n" 
		  . "\t/** \n" 
		  . "\t* Show Debugger Console. \n"
		  . "\t* Display errors in console view. Not recomended for live site. true/false \n"
		  . "\t*/\n"
		  . "\t define('DEBUG', false);\n"
		  . "?>";
      
	  if($safe) {
		  return $content;
	  } else {
		  $confile = '../lib/config.ini.php';
		  if (is_writable('../lib/')) {
			  $handle = fopen($confile, 'w');
			  fwrite($handle, $content);
			  fclose($handle);
			  return true;
		  } else {
			  return false;
		  }
	  }
  }

  /**
   * cmsHeader()
   * 
   * @return
   */
  function cmsHeader()
  {
	  
      echo '<!doctype html>' . "\n";
      echo '<html>' . "\n";
      echo '<head>' . "\n";
      echo '<meta charset="utf-8">' . "\n";
      echo '<title>Wojoscripts - Web Installer</title>' . "\n";
      echo '<link rel="stylesheet" type="text/css" href="style.css">' . "\n";
      echo '</head>' . "\n";
      echo '<body>' . "\n";
	  echo '<div id="wrap">' . "\n";
	  echo '<header class="clearfix"><img src="images/logo.svg" alt="W">Welcome to MMP pro Install Wizard</header>' . "\n";
	  echo '<div class="line"></div>' . "\n";
	  echo '<div id="content">' . "\n";
  }
  
  /**
   * cmsFooter()
   * 
   * @return
   */
  function cmsFooter()
  {
      
      echo '</div>' . "\n";
	  echo '</div>' . "\n";
      echo '<div id="copyright">Wojoscripts<br />' . "\n";
      echo 'Copyright &copy; ' . date("Y") . ' Wojoscripts.com';
      echo '</div>' . "\n";
      echo '<script type="text/javascript">' . "\n";
      
      if (isset($_SESSION['err'])) {
          $j = 0;
          foreach ($_SESSION['err'] as $key => $i) {
              if ($i > 0) {
                  $first = ($j > 0) ? $i : '';
                  echo "document.getElementById('err{$i}').style.display = 'block';\n";
                  echo "document.getElementById('t{$i}').style.background = '#bf360c';\n";
                  $j++;
              }
          }
          echo "document.getElementById('t{$_SESSION['err'][0]}').focus();\n";
      }
      
      echo '</script>' . "\n";
      echo '</body>' . "\n";
      echo '</html>' . "\n";
  }