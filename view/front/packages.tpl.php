<?php
  /**
   * Packages
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: packages.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<h1><?php echo Lang::$word->META_T29;?></h1>
<?php if($this->data):?>
<div class="row screen-block-3 tablet-block-2 mobile-block-1 phone-block-1 double-gutters align-center">
  <?php foreach($this->data as $row):?>
  <div class="column" id="item_<?php echo $row->id;?>">
    <div class="wojo shadow attached segment content-center relative">
      <?php if($row->thumb):?>
      <img src="<?php echo UPLOADURL;?>/memberships/<?php echo $row->thumb;?>" alt="">
      <?php else:?>
      <img src="<?php echo UPLOADURL;?>/memberships/default.png" alt="">
      <?php endif;?>
      <div class="wojo space divider"></div>
      <h4 class="content-center"><?php echo Utility::formatMoney($row->price);?> <?php echo $row->title;?></h4>
      <p><?php echo Lang::$word->MEM_REC1;?> <?php echo ($row->recurring) ? Lang::$word->YES : Lang::$word->NO;?></p>
      <p class="wojo tiny text"><?php echo $row->description;?></p>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>