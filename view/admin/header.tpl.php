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

  if (!App::Auth()->is_Admin()) {
	  Url::redirect(SITEURL . '/admin/login/'); 
	  exit; 
  }
 ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/global.js"></script>
<link href="<?php echo ADMINVIEW . '/cache/' . Cache::cssCache(array('base.css','transition.css','dropdown.css','menu.css','image.css','label.css','message.css','list.css','table.css','datepicker.css','divider.css','form.css','input.css','icon.css','button.css','segment.css','editor.css','popup.css','dimmer.css','modal.css','progress.css','utility.css','style.css'), ADMINBASE);?>" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
</head>
<body>
<div id="mResults" class="wojo page inverted dimmer">
  <div class="padding"></div>
</div>
<div id="wrapper">
<div class="container">
<aside> <a id="mnav-alt"><i class="icon reorder"></i></a> <a href="<?php echo ADMINURL;?>/" class="logo"><?php echo (App::Core()->logo) ? '<img src="' . SITEURL . '/uploads/' . App::Core()->logo . '" alt="'.App::Core()->company . '">': App::Core()->company;?></a>
  <div class="menuwrap">
    <nav>
      <ul>
        <li<?php if (count($this->segments) == 1) echo ' class="active"';?>><a href="<?php echo ADMINURL;?>"><img src="<?php echo ADMINVIEW;?>/images/dash.svg"> <span><?php echo Lang::$word->ADM_DASH;?></span></a></li>
        <li<?php if (Utility::in_array_any(["templates","countries","coupons","fields","news","mailer"], $this->segments)) echo ' class="active"';?>><a class="collapsed"><img src="<?php echo ADMINVIEW;?>/images/content.svg"> <span><?php echo Lang::$word->ADM_CONTENT;?></span></a>
          <ul>
            <li><a<?php if (in_array("templates", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/templates");?>"><?php echo Lang::$word->ADM_EMTPL;?></a></li>
            <li><a<?php if (in_array("countries", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/countries");?>"><?php echo Lang::$word->ADM_CNTR;?></a></li>
            <li><a<?php if (in_array("coupons", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/coupons");?>"><?php echo Lang::$word->ADM_COUPONS;?></a></li>
            <li><a<?php if (in_array("fields", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/fields");?>"><?php echo Lang::$word->ADM_CFIELDS;?></a></li>
            <li><a<?php if (in_array("news", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/news");?>"><?php echo Lang::$word->ADM_NEWS;?></a></li>
            <li><a<?php if (in_array("mailer", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/mailer");?>"><?php echo Lang::$word->ADM_NEWSL;?></a></li>
          </ul>
        </li>
        <li<?php if (in_array("users", $this->segments)) echo ' class="active"';?>><a href="<?php echo Url::url("/admin/users");?>"><img src="<?php echo ADMINVIEW;?>/images/users.svg"> <span><?php echo Lang::$word->ADM_USERS;?></span></a></li>
        <li<?php if (in_array("memberships", $this->segments)) echo ' class="active"';?>><a href="<?php echo Url::url("/admin/memberships");?>"><img src="<?php echo ADMINVIEW;?>/images/membership.svg"> <span><?php echo Lang::$word->ADM_MEMBS;?></span></a></li>
        <li<?php if (in_array("files", $this->segments)) echo ' class="active"';?>><a href="<?php echo Url::url("/admin/files");?>"><img src="<?php echo ADMINVIEW;?>/images/files.svg"> <span><?php echo Lang::$word->ADM_FILES;?></span></a></li>
        <li<?php if (Utility::in_array_any(["configuration","language","backup","gateways","maintenance"], $this->segments)) echo ' class="active"';?>><a class="collapsed"><img src="<?php echo ADMINVIEW;?>/images/settings.svg"> <span><?php echo Lang::$word->ADM_CONFIG;?></span></a>
          <ul>
            <li><a<?php if (in_array("configuration", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/configuration");?>"><?php echo Lang::$word->ADM_STNG;?></a></li>
            <li><a<?php if (in_array("language", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/language");?>"><?php echo Lang::$word->ADM_LNGMNG;?></a></li>
            <li><a<?php if (in_array("backup", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/backup");?>"><?php echo Lang::$word->ADM_BACKUP;?></a></li>
            <li><a<?php if (in_array("maintenance", $this->segments)) echo ' class="active"';?> href="<?php echo Url::url("/admin/maintenance");?>"><?php echo Lang::$word->ADM_MTNC;?></a></li>
          </ul>
        </li>
        <li<?php if (in_array("help", $this->segments)) echo ' class="active"';?>><a href="<?php echo Url::url("/admin/help");?>"><img src="<?php echo ADMINVIEW;?>/images/help.svg"> <span><?php echo Lang::$word->ADM_HELP;?></span></a></li>
      </ul>
    </nav>
  </div>
</aside>
<main>
<div class="row half-vertical-gutters align-middle">
  <div class="column shrink"><a id="mnav"><i class="icon reorder"></i></a></div>
  <div class="column">
    <div class="wojo small breadcrumb"> <?php echo Url::crumbs($this->crumbs ? $this->crumbs : $this->segments, "//", Lang::$word->HOME);?> </div>
  </div>
  <div class="column shrink padding-right">
    <div class="wojo top right pointing dropdown"><img src="<?php echo UPLOADURL;?>/avatars/<?php echo (App::Auth()->avatar) ? App::Auth()->avatar : "blank.png";?>" alt="" class="wojo basic tiny circular image">
      <div class="menu"> <a class="item" href="<?php echo Url::url("/admin/myaccount");?>"><i class="icon note"></i><?php echo Lang::$word->M_MYACCOUNT;?></a> <a class="item" href="<?php echo Url::url("/admin/myaccount/password");?>"> <i class="icon lock"></i><?php echo Lang::$word->M_SUB2;?></a> </div>
    </div>
  </div>
  <?php if (Auth::checkAcl("owner")):?>
  <div class="column shrink padding-right">
    <div class="wojo top right pointing dropdown"><i class="icon black apps link"></i>
      <div class="menu"> <a class="item" href="<?php echo Url::url("/admin/permissions");?>"><?php echo Lang::$word->ADM_PERMS;?></a> 
      <a class="item" href="<?php echo Url::url("/admin/gateways");?>"><?php echo Lang::$word->ADM_GATE;?></a> 
      <a class="item" href="<?php echo Url::url("/admin/transactions");?>"><?php echo Lang::$word->ADM_TRANS;?></a>
      <a class="item" href="<?php echo Url::url("/admin/system");?>"><?php echo Lang::$word->ADM_SYSTEM;?></a>
      <a class="item" href="<?php echo Url::url("/admin/trash");?>"><?php echo Lang::$word->ADM_TRASH;?></a>
      </div>
    </div>
  </div>
  <?php endif;?>
  <div class="column shrink"><a href="<?php echo Url::url("/admin/logout");?>"><i class="icon black power link"></i></a></div>
</div>