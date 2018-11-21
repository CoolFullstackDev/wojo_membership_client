<?php
  /**
   * Header
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: header.tpl.php, v1.00 2015-10-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
 ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo isset($this) ? $this->title : App::Core()->company;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/global.js"></script>
<link href="<?php echo FRONTVIEW . '/cache/' . Cache::cssCache(array('base.css','transition.css','dropdown.css','menu.css','label.css','message.css','list.css','table.css','form.css','input.css','icon.css','button.css','segment.css','divider.css','dimmer.css','modal.css','utility.css','popup.css','style.css'), FRONTBASE);?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="menu">
<div class="actionButton"></div>
	<?php if(App::Auth()->is_User()):?>
    <a href="<?php echo Url::url("/dashboard");?>" class="sub dashboard" data-content="<?php echo Lang::$word->ADM_DASH;?>" data-position="left center"></a>
    <?php else:?>
    <a href="<?php echo Url::url('');?>" class="sub login" data-content="<?php echo Lang::$word->M_SUB16;?>" data-position="left center"></a>  
    <a href="<?php echo Url::url("/register");?>" class="sub register" data-content="<?php echo Lang::$word->M_SUB17;?>" data-position="left center"></a>  
    <?php endif;?>
    <a href="<?php echo Url::url("/packages");?>" class="sub packages" data-content="<?php echo Lang::$word->ADM_MEMBS;?>" data-position="left center"></a>  
    <a href="<?php echo Url::url("/contact");?>" class="sub contact" data-content="<?php echo Lang::$word->CONTACT;?>" data-position="left center"></a> 
    <?php if(App::Auth()->is_User()):?>
    <a href="<?php echo Url::url("/logout");?>" class="sub logout" data-content="<?php echo Lang::$word->LOGOUT;?>" data-position="left center"></a> 
    <?php endif;?>
    <a class="sub news" data-content="<?php echo Lang::$word->ADM_NEWS;?>" data-position="left center"></a>
</div>
<div class="wojo-grid">
<div id="logo"><a href="<?php echo SITEURL;?>/" class="logo"><?php echo (App::Core()->logo) ? '<img src="' . SITEURL . '/uploads/' . App::Core()->logo . '" alt="'.App::Core()->company . '">': App::Core()->company;?></a></div>