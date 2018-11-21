<?php
  /**
   * Dashboard
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: dashboard.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="content-center"><img src="<?php echo UPLOADURL;?>/avatars/<?php echo (App::Auth()->avatar) ? App::Auth()->avatar : "blank.png";?>" alt="" class="avatar"></div>
<div class="wojo big space divider"></div>
<div class="clearfix" id="tabs-alt"> <a class="active"> <?php echo Lang::$word->ADM_MEMBS;?></a> <a class="static" href="<?php echo Url::url("/dashboard/history");?>"><?php echo Lang::$word->HISTORY;?></a> <a class="static" href="<?php echo Url::url("/dashboard/profile");?>"><?php echo Lang::$word->M_SUB18;?></a> 
<a class="static" href="<?php echo Url::url("/dashboard/downloads");?>"><?php echo Lang::$word->DOWNLOADS;?></a></div>
<div class="login-form">
<?php if($this->data):?>
<div class="row screen-block-3 tablet-block-2 mobile-block-1 phone-block-1 double-gutters align-center">
  <?php foreach($this->data as $row):?>
  <div class="column" id="item_<?php echo $row->id;?>">
    <div class="wojo attached segment content-center relative<?php echo App::Auth()->membership_id == $row->id ? ' frame' : null;?>">
      <?php if($row->thumb):?>
      <img src="<?php echo UPLOADURL;?>/memberships/<?php echo $row->thumb;?>" alt="">
      <?php else:?>
      <img src="<?php echo UPLOADURL;?>/memberships/default.png" alt="">
      <?php endif;?>
      <div class="wojo space divider"></div>
      <h4 class="content-center"><?php echo Utility::formatMoney($row->price);?> <?php echo $row->title;?></h4>
      <p class="wojo small text"><?php echo Lang::$word->MEM_REC1;?> <?php echo ($row->recurring) ? Lang::$word->YES : Lang::$word->NO;?></p>
      <p class="wojo small text"><?php echo $row->days;?>@<?php echo Date::getPeriodReadable($row->period);?></p>
      <p class="wojo tiny text"><?php echo $row->description;?></p>
      <?php if(App::Auth()->membership_id != $row->id):?>
      <p><a class="wojo small button add-cart" data-id="<?php echo $row->id;?>"><?php echo ($row->price <> 0) ? Lang::$word->M_SUB19 : Lang::$word->M_SUB20;?></a></p>
      <?php endif;?>
    </div>
  </div>
  <?php endforeach;?>
  <?php unset($row);?>
</div>
<?php endif;?>
<div id="mResult"></div>