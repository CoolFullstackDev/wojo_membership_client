<?php
  /**
   * Membership Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: _memberships_grid.tpl.php, v1.00 2016-07-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="row half-gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->META_T6;?></h3>
    <p class="wojo small text"><?php echo Lang::$word->MEM_SUB;?></p>
  </div>
  <div class="column shrink mobile-100 phone-100"> <a href="<?php echo Url::url(Router::$path, "new/");?>" class="wojo small secondary button"><i class="icon plus alt"></i><?php echo Lang::$word->MEM_SUB1;?></a> </div>
</div>
<div class="wojo big space divider"></div>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->MEM_NOMEM;?></p>
</div>
<?php else:?>
<div class="row screen-block-3 tablet-block-2 mobile-block-1 phone-block-1 double-gutters align-center">
  <?php foreach($this->data as $row):?>
  <div class="column" id="item_<?php echo $row->id;?>">
    <div class="wojo attached segment content-center relative">
    <span class="wojo top left attached simple label"><?php echo $row->id;?></span>
      <?php if($row->thumb):?>
      <img src="<?php echo UPLOADURL;?>/memberships/<?php echo $row->thumb;?>" alt="">
      <?php else:?>
      <img src="<?php echo UPLOADURL;?>/memberships/default.png" alt="">
      <?php endif;?>
      <div class="wojo space divider"></div>
      <h4 class="content-center"><?php echo Utility::formatMoney($row->price);?> <?php echo $row->title;?></h4>
      <p class="wojo tiny text"><?php echo Validator::truncate($row->description,40);?></p>
      <a href="<?php echo Url::url(Router::$path, "history/" . $row->id);?>" class="wojo small label"><?php echo $row->total;?> <span class="detail"><?php echo Lang::$word->TRX_SALES;?></span></a>
      <div class="wojo divider"></div>
      <a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="wojo icon circular basic positive small button"><i class="icon pencil"></i></a> <a data-set='{"option":[{"trash": "trashMembership","title": "<?php echo $row->title;?>","id":<?php echo $row->id;?>}],"action":"trash","parent":"#item_<?php echo $row->id;?>"}' class="wojo icon circular basic negative small button action"> <i class="icon trash"></i> </a> </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>