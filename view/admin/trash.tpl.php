<?php
  /**
   * Trash
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: trash.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if (!Auth::checkAcl("owner")) : print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<div class="row half-gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->TRS_TITLE;?></h3>
    <p class="wojo small text"><?php echo Lang::$word->TRS_INFO;?></p>
  </div>
  <?php if($this->data):?>
  <div class="column shrink mobile-100 phone-100"> <a data-set='{"option":[{"delete": "trashAll","title": "<?php echo Lang::$word->TRS_TEMPTY;?>"}],"action":"delete","parent":"#self","redirect":"<?php echo Url::url(Router::$path);?>"}' class="action wojo small negative button"><?php echo Lang::$word->TRS_TEMPTY;?> </a> </div>
  <?php endif;?>
</div>
<?php if(!$this->data):?>
<div class="wojo segment content-center"><img src="<?php echo ADMINVIEW;?>/images/trash_empty.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->TRS_NOTRS;?></p>
</div>
<?php else:?>
<?php foreach($this->data as $type => $rows):?>
<?php switch($type): ?>
<?php case "user":?>
<div class="wojo basic segment">
  <table class="wojo small basic table">
    <thead>
      <tr>
        <th colspan="2"><h4><?php echo Lang::$word->ADM_USERS;?></h4></th>
      </tr>
    </thead>
    <?php foreach($rows as $row):?>
    <?php $dataset = Utility::jSonToArray($row->dataset);?>
    <tr id="user_<?php echo $dataset->id;?>">
      <td><?php echo $dataset->fname;?> <?php echo $dataset->lname;?></td>
      <td class="collapsing"><a data-set='{"option":[{"simpleAction": 1,"action":"restoreUser", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->fname . ' ' . $dataset->lname;?>", "url":"/helper.php", "parent":"#user_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->RESTORE;?></a> - <a data-set='{"option":[{"simpleAction": 1,"action":"deleteUser", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->fname . ' ' . $dataset->lname;?>", "url":"/helper.php", "parent":"#user_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->TRS_DELGOOD;?></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($dataset);?>
  </table>
</div>
<?php break;?>
<?php case "membership":?>
<div class="wojo basic segment">
  <table class="wojo small basic table">
    <thead>
      <tr>
        <th colspan="2"><h4><?php echo Lang::$word->ADM_MEMBS;?></h4></th>
      </tr>
    </thead>
    <?php foreach($rows as $row):?>
    <?php $dataset = Utility::jSonToArray($row->dataset);?>
    <tr id="membership_<?php echo $dataset->id;?>">
      <td><?php echo $dataset->title;?></td>
      <td class="collapsing"><a data-set='{"option":[{"simpleAction": 1,"action":"restoreMembership", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#membership_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->RESTORE;?></a> - <a data-set='{"option":[{"simpleAction": 1,"action":"deleteMembership", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#membership_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->TRS_DELGOOD;?></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($dataset);?>
  </table>
</div>
<?php break;?>
<?php case "news":?>
<div class="wojo basic segment">
  <table class="wojo small basic table">
    <thead>
      <tr>
        <th colspan="2"><h4><?php echo Lang::$word->ADM_NEWS;?></h4></th>
      </tr>
    </thead>
    <?php foreach($rows as $row):?>
    <?php $dataset = Utility::jSonToArray($row->dataset);?>
    <tr id="news_<?php echo $dataset->id;?>">
      <td><?php echo $dataset->title;?></td>
      <td class="collapsing"><a data-set='{"option":[{"simpleAction": 1,"action":"restoreNews", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#news_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->RESTORE;?></a> - <a data-set='{"option":[{"simpleAction": 1,"action":"deleteNews", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#news_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->TRS_DELGOOD;?></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($dataset);?>
  </table>
</div>
<?php break;?>
<?php case "coupon":?>
<div class="wojo basic segment">
  <table class="wojo small basic table">
    <thead>
      <tr>
        <th colspan="2"><h4><?php echo Lang::$word->ADM_COUPONS;?></h4></th>
      </tr>
    </thead>
    <?php foreach($rows as $row):?>
    <?php $dataset = Utility::jSonToArray($row->dataset);?>
    <tr id="coupon_<?php echo $dataset->id;?>">
      <td><?php echo $dataset->title;?></td>
      <td class="collapsing"><a data-set='{"option":[{"simpleAction": 1,"action":"restoreCoupon", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#coupon_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->RESTORE;?></a> - <a data-set='{"option":[{"simpleAction": 1,"action":"deleteCoupon", "id":<?php echo $row->id;?>}], "name":"<?php echo $dataset->title;?>", "url":"/helper.php", "parent":"#coupon_<?php echo $dataset->id;?>", "after":"remove"}' class="item simpleAction"><?php echo Lang::$word->TRS_DELGOOD;?></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($dataset);?>
  </table>
</div>
<?php break;?>
<?php endswitch;?>
<?php endforeach;?>
<?php endif;?>