<?php
  /**
   * User Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: _users_list.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="row half-gutters align-middle">
  <div class="column shrink mobile-100 mobile-order-1">
    <h3><?php echo Lang::$word->META_T2;?></h3>
  </div>
  <div class="columns content-right mobile-50 mobile-content-left mobile-order-2"> <a href="<?php echo Url::url(Router::$path, "new/");?>" class="wojo small secondary button"><i class="icon plus alt"></i><?php echo Lang::$word->M_TITLE5;?></a> </div>
  <div class="columns mobile-100 mobile-order-4">
    <div class="wojo small fluid inverted icon input">
      <input id="masterSearch" placeholder="<?php echo Lang::$word->SEARCH;?>" data-page="users" type="text">
      <i class="icon find"></i> </div>
  </div>
  <div class="columns shrink mobile-50 mobile-order-3 mobile-content-right">
    <div class="wojo small icon buttons"> <a class="wojo icon active button"><i class="icon reorder"></i></a> <a href="<?php echo Url::url(Router::$path, "grid/");?>" class="wojo icon button"><i class="icon grid list"></i></a> </div>
    <a href="<?php echo ADMINVIEW . '/helper.php?exportUsers';?>" class="wojo small basic label"><?php echo Lang::$word->EXPORT;?></a> </div>
</div>
<div class="half-top-padding">
  <div class="wojo divided horizontal link list align-center">
    <div class="disabled item wojo bold text"> <?php echo Lang::$word->SORTING_O;?> </div>
    <a href="<?php echo Url::url(Router::$path);?>" class="item<?php echo Url::setActive("order", false);?>"> <?php echo Lang::$word->RESET;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=membership_id|DESC");?>" class="item<?php echo Url::setActive("order", "membership_id");?>"> <?php echo Lang::$word->MEMBERSHIP;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=username|DESC");?>" class="item<?php echo Url::setActive("order", "username");?>"> <?php echo Lang::$word->USERNAME;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=fname|DESC");?>" class="item<?php echo Url::setActive("order", "fname");?>"> <?php echo Lang::$word->NAME;?> </a>
    <div class="item"><a href="<?php echo Url::sortItems(Url::url(Router::$path), "order");?>" data-content="ASC/DESC"><i class="icon triangle unfold more link"></i></a> </div>
  </div>
</div>
<div class="half-top-padding"><?php echo Validator::alphaBits(Url::url(Router::$path), "letter", "wojo small bold text horizontal link divided list align-center");?> </div>
<div class="wojo space divider"></div>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->M_INFO6;?></p>
</div>
<?php else:?>
<?php foreach($this->data as $row):?>
<div class="wojo card" id="item_<?php echo $row->id;?>">
  <div class="header">
    <div class="row horizontal-gutters align-bottom">
      <div class="column shrink"><img src="<?php echo UPLOADURL;?>/avatars/<?php echo $row->avatar ? $row->avatar : "blank.png" ;?>" alt="" class="wojo avatar image"></div>
      <div class="column shrink">
        <p class="wojo black small text"><i class="icon date"></i> <?php echo Date::doDate("short_date", $row->created);?></p>
        <span class="wojo bold medium text">
        <?php if(Auth::hasPrivileges('edit_user')):?>
        <a class="inverted" href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>"><?php echo $row->fullname;?></a>
        <?php else:?>
        <?php echo $row->fullname;?>
        <?php endif;?>
        </span></div>
      <div class="column">
        <div><?php echo Utility::userType($row->type);?></div>
      </div>
      <div class="column shrink align-top"> <?php echo Utility::status($row->active, $row->id);?> </div>
    </div>
  </div>
  <div class="footer">
    <div class="row align-middle">
      <div class="column">
        <div class="wojo horizontal inverted small list">
          <div class="item">
            <div class="header"><span class="wojo caps light text"><?php echo Lang::$word->M_EMAIL1;?></span> <span class="wojo caps text"><a href="<?php echo Url::url("/admin/mailer", "?email=" . urlencode($row->email));?>" class="white"><?php echo $row->email;?></a></span> </div>
          </div>
          <div class="item">
            <div class="header"><span class="wojo caps light text"><?php echo Lang::$word->MEMBERSHIP;?></span> <span class="wojo caps text"><?php echo ($row->membership_id) ? '<a href="' . Url::url("/admin/memberships/edit/" . $row->membership_id) . '" class="white wojo caps text">' . $row->mtitle . '</a>' : '-/-';?></span> </div>
          </div>
        </div>
      </div>
      <div class="column shrink">
        <div class="wojo pointing top right dropdown"><i class="icon white horizontal ellipsis link"></i>
          <div class="menu">
            <?php if(Auth::hasPrivileges('edit_user')):?>
            <a class="item" href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>"><i class="icon pencil"></i> <?php echo Lang::$word->EDIT;?></a>
            <?php endif;?>
            <a class="item" href="<?php echo Url::url(Router::$path, "history/" . $row->id);?>"><i class="icon history"></i> <?php echo Lang::$word->HISTORY;?></a>
            <?php if(Auth::hasPrivileges('delete_user')):?>
            <div class="wojo basic divider"></div>
            <a data-set='{"option":[{"trash": "trashUser","title": "<?php echo $row->fullname;?>","id":<?php echo $row->id;?>}],"action":"trash","parent":"#item_<?php echo $row->id;?>"}' class="item action"> <i class="icon trash"></i> <?php echo Lang::$word->TRASH;?></a>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php endif;?>
<div class="row half-gutters-mobile half-gutters-phone align-middle">
  <div class="columns shrink mobile-100 phone-100">
    <div class="wojo small thick text"><?php echo Lang::$word->TOTAL.': '.$this->pager->items_total;?> / <?php echo Lang::$word->CURPAGE.': '.$this->pager->current_page.' '.Lang::$word->OF.' '.$this->pager->num_pages;?></div>
  </div>
  <div class="columns mobile-100 phone-100 content-right mobile-content-left"><?php echo $this->pager->display_pages('small');?></div>
</div>