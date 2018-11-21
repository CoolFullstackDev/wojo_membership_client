<?php

  /**
   * File Class
   *
   * package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: file.class.php, v1.00 2016-04-20 18:20:24 gewa Exp $
   */

  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class File
  {

      /**
       * File::getExtension()
       * 
       * @param mixed $path
       * @return
       */
      public static function getExtension($path)
      {
          return pathinfo($path, PATHINFO_EXTENSION);
      }

      /**
       * File::deleteRecrusive()
       * 
       * Usage File::deleteRecrusive("test/dir");
       * @param string $dir
       * @param string $removeParent - remove parent directory
       * @return
       */
      public static function deleteRecrusive($dir = '', $removeParent = false)
      {
          if (is_dir($dir)) {
              $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
              $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
              foreach ($ri as $file) {
                  $file->isDir() ? rmdir($file) : unlink($file);
              }
              $removeParent ? self::deleteDirectory($dir) : null;
              return true;
          } else {
              return true;
          }
      }

      /**
       * File::deleteMulti()
       * 
       * @param string $dir
       * @return
       */
      public static function deleteMulti($dir)
      {
          if (is_dir($dir)) {
			  self::deleteRecrusive($dir, true);
		  } else {
			  self::deleteFile($dir);
		  }
      }
	  
      /**
       * File::deleteDirectory()
       * 
       * @param string $dir
       * @return
       */
      public static function deleteDirectory($dir = '')
      {
          self::emptyDirectory($dir);
          return rmdir($dir);
      }

      /**
       * File::makeDirectory()
       * 
       * /my/path/to/dir/
       * @param string $dir
       * @return
       */
      public static function makeDirectory($dir = '')
      {
          if (!file_exists($dir)) {
              if (false === mkdir($dir, 0755, true)) {
                  self::_errorHanler('directory-error', 'Directory not writable {dir}.', array('{dir}' => $dir));
              }
			  return true;
          }
      }

      /**
       * File::renameDirectory()
       * 
       * /my/path/to/dir
       * @param string $old
       * @param string $new
       * @return
       */
      public static function renameDirectory($old = '', $new = '')
      {
          if (file_exists($old)) {
              if (false === rename($old, $new)) {
                  self::_errorHanler('directory-error', 'Can\'t rename {dir}.', array('{dir}' => $new));
              }
          }
      }

      /**
       * File::emptyDirectory()
       * 
       * @param string $dir
       * @return
       */
      public static function emptyDirectory($dir = '')
      {
          foreach (glob($dir . '/*') as $file) {
              if (is_dir($file)) {
                  self::emptyDirectory($file);
              } else {
                  unlink($file);
              }
          }
          return true;
      }

      /**
       * File::copyDirectory()
       * 
       * Copies content of source directory into destination directory
       * Warning: if the destination file already exists, it will be overwritten
       * @param string $src
       * @param string $dest
       * @param bool $fullPath
       * @return
       */
      public static function copyDirectory($src = '', $dest = '', $fullPath = true)
      {
          $result = false;
          $dirPath = (($fullPath) ? BASEPATH : '') . $src;

          if (is_dir($dirPath)) {
              $dir = opendir($dirPath);
              if (!$dir)
                  return $result;
              if (!file_exists(trim($dest, '/') . '/'))
                  mkdir((($fullPath) ? BASEPATH : '') . $dest);
              while (false !== ($file = readdir($dir))) {
                  if (($file != '.') && ($file != '..')) {
                      $fromDir = trim($src, '/') . '/' . $file;
                      $toDir = trim($dest, '/') . '/' . $file;
                      if (is_dir($fromDir)) {
                          $result = self::copyDirectory($fromDir, $toDir, $fullPath);
                      } else {
                          $result = copy($fromDir, $toDir);
                      }
                  }
              }
              closedir($dir);
          }

          return $result;
      }

      /**
       * File::isDirectoryEmpty()
       * 
       * @param string $dir
       * @return
       */
      public static function isDirectoryEmpty($dir = '')
      {
          if ($dir == '' || !is_readable($dir))
              return false;
          $hd = opendir($dir);
          while (false !== ($entry = readdir($hd))) {
              if ($entry !== '.' && $entry !== '..') {
                  return false;
              }
          }
          closedir($hd);
          return true;
      }

      /**
       * File::getDirectoryFilesNumber()
       * 
       * @param string $dir
       * @return
       */
      public static function getDirectoryFilesNumber($dir = '')
      {
          return count(glob($dir . '*'));
      }

      /**
       * File::removeDirectoryOldestFile()
       * 
       * @param string $dir
       * @return
       */
      public static function removeDirectoryOldestFile($dir = '')
      {
          $oldestFileTime = date('Y-m-d H:i:s');
          $oldestFileName = '';
          if ($hdir = opendir($dir)) {
              while (false !== ($obj = readdir($hdir))) {
                  if ($obj == '.' || $obj == '..' || $obj == '.htaccess')
                      continue;
                  $fileTime = date('Y-m-d H:i:s', filectime($dir . $obj));
                  if ($fileTime < $oldestFileTime) {
                      $oldestFileTime = $fileTime;
                      $oldestFileName = $obj;
                  }
              }
          }
          if (!empty($oldestFileName)) {
              self::deleteFile($dir . $oldestFileName);
          }
      }

      /**
       * File::findSubDirectories()
       * 
       * @param string $dir
       * @param bool $fullPath
       * @return
       */
      public static function findSubDirectories($dir = '.', $fullPath = false)
      {
          $subDirectories = array();
          $folder = dir($dir);
          while ($entry = $folder->read()) {
              if ($entry != '.' && $entry != '..' && is_dir($dir . $entry)) {
                  $subDirectories[] = ($fullPath ? $dir : '') . $entry;
              }
          }
          $folder->close();
          return $subDirectories;
      }


      /**
       * File::scanDirectory()
       * 
       * @param string $dir
       * @param bool $options
       * @param bool $sorting
       * @return
       */
      public static function scanDirectory($directory, $options = array(), $sorting)
      {

          if (substr($directory, -1) == '/') {
              $directory = substr($directory, 0, -1);
          }
          $base = substr(UPLOADS, 0, -1);
		  
          if (!file_exists($directory) || !is_dir($directory)) {
              self::_errorHanler('directory-error', 'Invalid directory selected {dir}.', array('{dir}' => $directory));
              return false;

          } elseif (is_readable($directory)) {
              $dirs = array();
              $files = array();

              $exclude = array(
                  "htaccess",
                  "git",
                  "php");

              $dirfiles = new DirectoryIterator($directory);
              foreach ($dirfiles as $file) {
                  $path = $directory . '/' . $file->getBasename();
                  $real_path = isset($options['showpath']) ? $path : str_replace(UPLOADS, "", $path);
                  if ($file->isDot() or in_array($file, array("thumbs", "backups")))
                      continue;

                  if ($file->isDir()) {
                      $dirs[] = array(
                          'path' => $real_path,
                          'url' => self::_fixPath(str_replace(UPLOADS, "", $file->getBasename()) . "/"),
                          'name' => str_replace("_", " ", $file->getBasename()),
                          'kind' => 'directory',
                          'total' => iterator_count(new FilesystemIterator($file->getPathname(), FilesystemIterator::SKIP_DOTS)));
                  }

                  if ($file->isFile()) {
                      if (isset($options['include'])) {
                          $filter = in_array(pathinfo($file->getBasename(), PATHINFO_EXTENSION), $options['include']);
                      } else {
                          $filter = !in_array(pathinfo($file->getBasename(), PATHINFO_EXTENSION), $exclude);
                      }

                      if ($file->getBasename() != "." && $file->getBasename() != ".." && $filter) {
						  $url = self::_fixPath(str_replace($base, "", $file->getPathname()));
                          $files[] = array(
                              'path' => $real_path,
							  'url' => ltrim($url, '/'),
                              'name' => $file->getBasename(),
                              'extension' => $file->getExtension(),
                              'mime' => self::getMimeType($file->getPathname()),
                              'is_image' => in_array($file->getExtension(), array(
                                  "jpg",
                                  "jpeg",
                                  "png",
                                  "gif",
                                  "bmp")) ? true : false,
                              'ftime' => Date::doDate("short_date", date('d-m-Y', $file->getMTime())),
                              'size' => File::getSize($file->getSize()),
                              'kind' => 'file');
                      }
                  }
              }

              $data['directory'] = $dirs;
			  $data['dirsize'] = count($dirs);
			  $data['filesize'] = count($files);

              switch ($sorting) {
                  case "date":
                      $data['files'] = Utility::sortArray($files, 'ftime');
                      break;

                  case "size":
                      $data['files'] = Utility::sortArray($files, 'size');
                      break;

                  case "name":
                      $data['files'] = Utility::sortArray($files, 'name');
                      break;

                  case "type":
                      $data['files'] = Utility::sortArray($files, 'extension');
                      break;

                  default:
                      $data['files'] = $files;
                      break;
              }


              return $data;
          } else {
              self::_errorHanler('directory-error', 'Directory not readable {dir}.', array('{dir}' => $directory));
              return false;
          }
      }

      /**
       * File::scanDirectoryRecursively()
       * 
       * @param string $dir
       * @param bool $options
       * @return
       */
      public static function scanDirectoryRecursively($directory, $options = array())
      {
          if (substr($directory, -1) == '/') {
              $directory = substr($directory, 0, -1);
          }

          if (!file_exists($directory) || !is_dir($directory)) {
              self::_errorHanler('directory-error', 'Invalid directory selected {dir}.', array('{dir}' => $directory));
              return false;

          } elseif (is_readable($directory)) {
              $iterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
              $all_files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

              $dirs = array();
              $files = array();
              $exclude = array(
                  "htaccess",
                  "git",
                  "php");

              foreach ($all_files as $file) {
                  $path = $directory . '/' . $file->getBasename();
                  $real_path = isset($options['showpath']) ? $path : str_replace(UPLOADS, "", $path);

                  if ($file->isDir()) {
                      $dirs[] = array(
                          'path' => $real_path,
                          'url' => str_replace(BASEPATH, "", $file->getPathname()) . "/",
                          'name' => str_replace("_", " ", $file->getBasename()),
                          'kind' => 'directory',
                          'total' => iterator_count(new FilesystemIterator($file->getPathname(), FilesystemIterator::SKIP_DOTS)));
                  }

                  if ($file->isFile()) {
                      if (isset($options['include'])) {
                          $filter = in_array(pathinfo($file->getBasename(), PATHINFO_EXTENSION), $options['include']);
                      } else {
                          $filter = !in_array(pathinfo($file->getBasename(), PATHINFO_EXTENSION), $exclude);
                      }

                      if ($file->getBasename() != "." && $file->getBasename() != ".." && $filter) {
                          $files[] = array(
                              'path' => $path,
                              'url' => str_replace(BASEPATH, "", $file->getPathname()),
                              'name' => $file->getBasename(),
                              'extension' => $file->getExtension(),
                              'mime' => self::getMimeType($file->getBasename()),
                              'is_image' => in_array($file->getExtension(), array(
                                  "jpg",
                                  "jpeg",
                                  "png",
                                  "gif",
                                  "bmp")) ? true : false,
                              'ftime' => Date::doDate("short_date", date('d-m-Y', $file->getMTime())),
                              'size' => File::getSize($file->getSize()),
                              'kind' => 'file');
                      }

                  }
              }

              $data['directory'] = $dirs;
              $data['files'] = $files;
              return $data;
          } else {
              self::_errorHanler('directory-error', 'Directory not readable {dir}.', array('{dir}' => $directory));
              return false;
          }
      }

      /**
       * File::getFile()
       * 
       * @param string $file
       * @return
       */
	  public static function getFile($file = '')
	  {
		  if (file_exists($file)) {
			  return $file;
		  } else {
			  self::_errorHanler('file-loading-error', 'An error occurred while fetching file {file}.', array('{file}' => $file));
		  }
	
	  }
	  
      /**
       * File::loadFile()
       * 
       * @param string $file
       * @return
       */
      public static function loadFile($file = '')
      {
          $content = file_get_contents($file);
          self::_errorHanler('file-loading-error', 'An error occurred while loading file {file}.', array('{file}' => $file));
          return $content;
      }

      /**
       * File::writeToFile()
       * 
       * @param string $file
       * @param string $content
       * @return
       */
      public static function writeToFile($file = '', $content = '')
      {
          file_put_contents($file, urldecode($content));
          self::_errorHanler('file-writing-error', 'An error occurred while writing to file {file}.', array('{file}' => $file));
          return true;
      }

      /**
       * File::copyFile()
       * 
       * @param string $src (absolute path BASEPATH . $sourcePath)
       * @param string $dest (absolute path BASEPATH . $targetPath)
       * @param string $src
       * @param string $dest
       * @return
       */
      public static function copyFile($src = '', $dest = '')
      {
          $result = copy($src, $dest);
          self::_errorHanler('file-coping-error', 'An error occurred while copying the file {source} to {destination}.', array('{source}' =>
                  $src, '{destination}' => $dest));
          return $result;
      }

      /**
       * File::findFiles()
       * 
       * Returns the files found under the given directory and subdirectories
       * Usage:
       * findFiles(
       *    $dir,
       *    array(
       *       'fileTypes'=>array('php', 'zip'),
       *   	 'exclude'=>array('html', 'htaccess', 'path/to/'),
       *   	 'level'=>-1,
       *       'returnType'=>'fileOnly'
       *  ))
       * fileTypes: array, list of file name suffix (without dot). 
       * exclude: array, list of directory and file exclusions. Each exclusion can be either a name or a path.
       * level: integer, recursion depth, (-1 - unlimited depth, 0 - current directory only, N - recursion depth)
       * returnType : 'fileOnly' or 'fullPath'
       * @param mixed $dir
       * @param mixed $options
       * @return
       */
      public static function findFiles($dir, $options = array())
      {
          $fileTypes = isset($options['fileTypes']) ? $options['fileTypes'] : array();
          $exclude = isset($options['exclude']) ? $options['exclude'] : array();
          $level = isset($options['level']) ? $options['level'] : -1;
          $returnType = isset($options['returnType']) ? $options['returnType'] : 'fileOnly';
          $filesList = self::_findFilesRecursive($dir, '', $fileTypes, $exclude, $level, $returnType);
          sort($filesList);
          return $filesList;
      }

      /**
       * File::deleteFile()
       * 
       * @param string $file
       * @return
       */
      public static function deleteFile($file = '')
      {
          $result = false;
          if (is_file($file)) {
              $result = unlink($file);
          }
          self::_errorHanler('file-deleting-error', 'An error occurred while deleting the file {file}.', array('{file}' => $file));
          return $result;
      }

      /**
       * File::getThemes()
       * 
       * @param mixed $dir
       * @param mixed $selected
       * @return
       */
      public static function getThemes($dir, $selected)
      {
          $directories = glob($dir . '/*', GLOB_ONLYDIR);
          if ($directories) {
              foreach ($directories as $row)
                  $dir = basename($row);
              $selected = ($selected == $dir) ? " selected=\"selected\"" : "";
              print "<option value=\"{$dir}\"{$selected}>{$dir}</option>\n";
          }
      }

      /**
       * File::getMailerTemplates()
       * 
       * @return
       */
      public static function getMailerTemplates()
      {
          $path = BASEPATH . "themes/mailer/";
          $files = glob($path . "*.{tpl.php}", GLOB_BRACE);

          return $files;
      }

      /**
       * File::getFileSize()
       * 
       * @param mixed $file
       * @param string $units
       * @param bool $print
       * @return
       */
      public static function getFileSize($file, $units = 'kb', $print = false)
      {
          if (!$file || !is_file($file))
              return 0;
          $showunit = $print ? $units : null;
          $filesSize = filesize($file);
          switch (strtolower($units)) {
              case 'g':
              case 'gb':
                  $result = number_format($filesSize / (1024 * 1024 * 1024), 2, '.', ',') . $showunit;
                  ;
                  break;
              case 'm':
              case 'mb':
                  $result = number_format($filesSize / (1024 * 1024), 2, '.', ',') . $showunit;
                  ;
                  break;
              case 'k':
              case 'kb':
                  $result = number_format($filesSize / 1024, 2, '.', ',') . $showunit;
                  break;
              case 'b':
              default:
                  $result = number_format($filesSize, 2, '.', ',') . $showunit;
                  ;
                  break;
          }
          return $result;
      }

      /**
       * File::getSize()
       * 
       * @param mixed $size
       * @param str $precision
       * @return
       */
      public static function getSize($size, $precision = 2)
      {
		  $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		  $step = 1024;
		  $i = 0;
		  while (($size / $step) > 0.9) {
			  $size = $size / $step;
			  $i++;
		  }
		  return round($size, $precision).$units[$i];
      }

      /**
       * File::directorySize()
       * 
       * @param str $dir
	   * @param bool $format
       * @return
       */
	  public static function directorySize($dir, $format = false){
		  $btotal = 0;
		  $dir = realpath($dir);
		  if($dir!==false){
			  foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $obj){
				  $btotal += $obj->getSize();
			  }
		  }
		  return $format ? self::getSize($btotal) : $btotal;
	  }

      /**
       * File::unzip()
       * 
       * @param str $archive
       * @param str $dir
       * @param bool $delete
       * @return
       */
      public static function unzip($archive, $dir)
      {

          // Check if webserver supports unzipping.
          if (!class_exists('ZipArchive')) {
              self::_errorHanler('zip-error', 'Your PHP version does not support unzip functionality.', array('{zip}' => 'ZipArchive'));
              return false;
          }

          if (substr($dir, -1) == '/') {
              $dir = substr($dir, 0, -1);
          }

          if (!file_exists($archive) || !is_dir($dir)) {
              self::_errorHanler('directory-error', 'Invalid directory or file selected {dir}.', array('{dir}' => $dir));
              return false;

          } elseif (is_writeable($dir . '/')) {
              $zip = new ZipArchive;
              if ($zip->open($archive) === true) {
                  $zip->extractTo($dir);
                  $zip->close();
              } else {
                  self::_errorHanler('zip-error', 'Cannot read .zip archive.', array('{zip}' => $archive));
              }

              return true;
          } else {
              self::_errorHanler('directory-error', 'Directory not writeable {dir}.', array('{dir}' => $dir));
              return false;
          }
      }

      /**
       * File::createShortenName()
       * 
       * @param mixed $file
       * @param integer $lengthFirst
       * @param integer $lengthLast
       * @return
       */
      public static function createShortenName($file, $lengthFirst = 10, $lengthLast = 10)
      {
          return preg_replace("/(?<=.{{$lengthFirst}})(.+)(?=.{{$lengthLast}})/", "...", $file);
      }


      /**
       * File::getMimeType()
       * 
       * @param mixed $file
       * @return
       */
      public static function getMimeType($file)
      {

          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mtype = finfo_file($finfo, $file);
          finfo_close($finfo);

          return $mtype;
      }

      /**
       * File::download()
       * 
       * @param mixed $fileLocation
	   * @param mixed $fileName
	   * @param int $maxSpeed
       * @return
       */
	  public static function download($fileLocation, $fileName, $maxSpeed = 1024)
	  {
		  if (connection_status() != 0)
			  return (false);
		  $extension = strtolower(substr($fileName, strrpos($fileName, '.') + 1));
	
		  /* List of File Types */
		  $fileTypes['swf'] = 'application/x-shockwave-flash';
		  $fileTypes['pdf'] = 'application/pdf';
		  $fileTypes['exe'] = 'application/octet-stream';
		  $fileTypes['zip'] = 'application/zip';
		  $fileTypes['doc'] = 'application/msword';
		  $fileTypes['docx'] = 'application/msword';
		  $fileTypes['xls'] = 'application/vnd.ms-excel';
		  $fileTypes['xlsx'] = 'application/vnd.ms-excel';
		  $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
		  $fileTypes['gif'] = 'image/gif';
		  $fileTypes['png'] = 'image/png';
		  $fileTypes['jpeg'] = 'image/jpg';
		  $fileTypes['jpg'] = 'image/jpg';
		  $fileTypes['rar'] = 'application/rar';
	
		  $fileTypes['ra'] = 'audio/x-pn-realaudio';
		  $fileTypes['ram'] = 'audio/x-pn-realaudio';
		  $fileTypes['ogg'] = 'audio/x-pn-realaudio';
	
		  $fileTypes['wav'] = 'video/x-msvideo';
		  $fileTypes['wmv'] = 'video/x-msvideo';
		  $fileTypes['avi'] = 'video/x-msvideo';
		  $fileTypes['asf'] = 'video/x-msvideo';
		  $fileTypes['divx'] = 'video/x-msvideo';
	
		  $fileTypes['mp3'] = 'audio/mpeg';
		  $fileTypes['mp4'] = 'audio/mpeg';
		  $fileTypes['mpeg'] = 'video/mpeg';
		  $fileTypes['mpg'] = 'video/mpeg';
		  $fileTypes['mpe'] = 'video/mpeg';
		  $fileTypes['mov'] = 'video/quicktime';
		  $fileTypes['swf'] = 'video/quicktime';
		  $fileTypes['3gp'] = 'video/quicktime';
		  $fileTypes['m4a'] = 'video/quicktime';
		  $fileTypes['aac'] = 'video/quicktime';
		  $fileTypes['m3u'] = 'video/quicktime';
	
		  $contentType = $fileTypes[$extension];
	
	
		  header("Cache-Control: public");
		  header("Content-Transfer-Encoding: binary\n");
		  header('Content-Type: $contentType');
	
		  $contentDisposition = 'attachment';
	
		  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
			  $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
			  header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
		  } else {
			  header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
		  }
	
		  header("Accept-Ranges: bytes");
		  $range = 0;
		  $size = filesize($fileLocation);
	
		  if (isset($_SERVER['HTTP_RANGE'])) {
			  list($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
			  str_replace($range, "-", $range);
			  $size2 = $size - 1;
			  $new_length = $size - $range;
			  header("HTTP/1.1 206 Partial Content");
			  header("Content-Length: $new_length");
			  header("Content-Range: bytes $range$size2/$size");
		  } else {
			  $size2 = $size - 1;
			  header("Content-Range: bytes 0-$size2/$size");
			  header("Content-Length: " . $size);
		  }
	
		  if ($size == 0) {
			  die('Zero byte file! Aborting download');
		  }
	
		  $fp = fopen("$fileLocation", "rb");
	
		  fseek($fp, $range);
	
		  while (!feof($fp) and (connection_status() == 0)) {
			  set_time_limit(0);
			  print (fread($fp, 1024 * $maxSpeed));
			  flush();
			  @ob_flush();
			  sleep(1);
		  }
		  fclose($fp);
		  exit;
	
		  return ((connection_status() == 0) and !connection_aborted());
	  } 
	  
      /**
       * File::exists()
       * 
       * @param mixed $file
       * @return
       */
      public static function exists($file)
      {

          return file_exists($file) ? true : false;
      }

      /**
       * File::_fixPath()
       * 
       * @param mixed $path
       * @return
       */
      public static function _fixPath($path)
      {
          $path = str_replace('\\', '/', $path);
          $path = preg_replace("#/+#", "/", $path);

          return $path;
      }

      /**
       * File::_findFilesRecursive()
       * 
       * @param mixed $dir
       * @param mixed $base
       * @param mixed $fileTypes
       * @param mixed $exclude
       * @param mixed $level
       * @param string $returnType
       * @return
       */
      protected static function _findFilesRecursive($dir, $base, $fileTypes, $exclude, $level, $returnType = 'fileOnly')
      {
          $list = array();
          if ($hdir = opendir($dir)) {
              while (($file = readdir($hdir)) !== false) {
                  if ($file === '.' || $file === '..')
                      continue;
                  $path = $dir . '/' . $file;
                  $isFile = is_file($path);
                  if (self::_validatePath($base, $file, $isFile, $fileTypes, $exclude)) {
                      if ($isFile) {
                          $list[] = ($returnType == 'fileOnly') ? $file : $path;
                      } else
                          if ($level) {
                              $list = array_merge($list, self::_findFilesRecursive($path, $base . '/' . $file, $fileTypes, $exclude, $level - 1, $returnType));
                          }
                  }
              }
          }
          closedir($hdir);
          return $list;
      }

      /**
       * File::validateDirectory()
       * 
       * @param mixed $basepath
       * @param mixed $userpath
       * @return
       */
      public static function validateDirectory($basepath, $userpath)
      {

          $realBase = realpath($basepath);
          $userpath = $basepath . $userpath;
          $realUserPath = realpath($userpath);

          return ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) ? $basepath : $userpath;
      }

      /**
       * File::_validatePath()
       * 
       * @param mixed $base
       * @param mixed $file
       * @param mixed $isFile
       * @param mixed $fileTypes
       * @param mixed $exclude
       * @return
       */
      protected static function _validatePath($base, $file, $isFile, $fileTypes, $exclude)
      {
          foreach ($exclude as $e) {
              if ($file === $e || strpos($base . '/' . $file, $e) === 0)
                  return false;
          }
          if (!$isFile || empty($fileTypes))
              return true;
          if (($type = pathinfo($file, PATHINFO_EXTENSION)) !== '') {
              return in_array($type, $fileTypes);
          } else {
              return false;
          }
      }

      /**
       * File::_errorHanler()
       * 
       * @param string $msgType
       * @param string $msg
       * @return
       */
      private static function _errorHanler($msgType = '', $msg = '')
      {
          if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
              $err = error_get_last();
              if (isset($err['message']) && $err['message'] != '') {
                  $lastError = $err['message'] . ' | file: ' . $err['file'] . ' | line: ' . $err['line'];
                  $errorMsg = ($lastError) ? $lastError : $msg;
                  Debug::addMessage('errors', $msgType, $errorMsg, 'session');
                  @trigger_error('');
              }
          }
      }

  }