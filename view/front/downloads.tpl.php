<?php
  /**
   * Downloads
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: downloads.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="content-center"><img src="<?php echo UPLOADURL;?>/avatars/<?php echo (App::Auth()->avatar) ? App::Auth()->avatar : "blank.png";?>" alt="" class="avatar"></div>
<div class="wojo big space divider"></div>
<div class="clearfix" id="tabs-alt"> <a href="<?php echo Url::url("/dashboard");?>" class="static"> <?php echo Lang::$word->ADM_MEMBS;?></a> <a class="static" href="<?php echo Url::url("/dashboard/history");?>"><?php echo Lang::$word->HISTORY;?></a> <a class="static" href="<?php echo Url::url("/dashboard/profile");?>"><?php echo Lang::$word->M_SUB18;?></a> <a class="active"><?php echo Lang::$word->DOWNLOADS;?></a></div>
<div class="login-form">
  <?php if(!$this->data):?>
  <div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
    <p class="wojo small thick caps text"><?php echo Lang::$word->AD_NO_DOWN;?></p>
  </div>
  <?php else:?>
  <p class="content-right"><span class="wojo basic label"><?php echo count($this->data);?> <?php echo Lang::$word->FM_FILES;?></span></p>
  <div class="row horizontal-gutters">
    <?php foreach($this->data as $i => $row):?>
    <?php if(!($i % 2) && $i > 0):?>
  </div>
  <div class="row horizontal-gutters">
    <?php endif;?>
    <div class="columns screen-50 tablet-50 mobile-100 phone-100">
      <div class="wojo very relaxed flex list align-middle">
        <div class="item">
          <a class="wojo shadow content half-padding shrink" style="background-color:<?php echo Content::fileStyle($row->extension);?>"><?php echo Content::fileIcon($row->extension, "small");?></a>
          <div class="content margin-left">
            <p class="header"><?php echo $row->alias;?></p>
            <p class="wojo small text"><?php echo Date::doDate("long_date", $row->created);?></p>
            <p class="wojo small text"><?php echo File::getSize($row->filesize);?> <span class="wojo separator"></span> <a href="<?php echo FRONTVIEW;?>/controller.php?token=<?php echo $row->token;?>"><?php echo Lang::$word->DOWNLOAD;?></a></p>
          </div>
        </div>
      </div>
      <div class="wojo basic divider"></div>
    </div>
    <?php endforeach;?>
  </div>
  <?php endif;?>
</div>