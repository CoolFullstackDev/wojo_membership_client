<?php
   
  /**
   * Captcha
   *
   * @package Freelance Manager
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: captcha.php, v2.00 2016-04-20 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
  require_once("init.php");
  
  header("Content-type: image/png");
  $text = rand(10000,99999); 
  App::Session()->set('captchacode', $text);
  $height = 25; 
  $width = 50; 
  $font_size = 12; 
  
  $im = imagecreatetruecolor($width, $height); 
  $textcolor = imagecolorallocate($im, 150, 150, 150);
  $bg = imagecolorallocate($im, 0, 0, 0);
  imagestring($im, $font_size, 5, 5, $text, $textcolor);
  imagecolortransparent($im, $bg);
  imagefill($im, 0, 0, $bg);
  
  imagepng($im, null,9);
  imagedestroy($im);