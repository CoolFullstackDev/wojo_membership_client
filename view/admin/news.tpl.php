<?php
  /**
   * News Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: news.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_news')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<?php switch(Url::segment($this->segments)): case "edit": ?>
<!-- Start edit -->
<h3><?php echo Lang::$word->META_T19;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->NAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->NAME;?>" value="<?php echo $this->data->title;?>" name="title">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <textarea class="bodypost" name="body"><?php echo str_replace("[SITEURL]", SITEURL, $this->data->body);?></textarea>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->PUBLISHED;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="active" type="radio" value="1" <?php Validator::getChecked($this->data->active, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="active" type="radio" value="0" <?php Validator::getChecked($this->data->active, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/news");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processNews" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->NW_UPDATE;?></button>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id;?>">
</form>
<?php break;?>
<?php case "new": ?>
<h3><?php echo Lang::$word->NW_SUB2;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->NAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->NAME;?>" name="title">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <textarea class="bodypost" name="body"></textarea>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->PUBLISHED;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="active" type="radio" value="1" checked="checked">
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="active" type="radio" value="0">
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/news");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processNews" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->NW_SUB2;?></button>
  </div>
</form>
<?php break;?>
<?php default: ?>
<div class="row half-gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->NW_TITLE;?></h3>
    <p class="wojo small text"><?php echo Lang::$word->NW_INFO;?></p>
  </div>
  <div class="column shrink mobile-100 phone-100"> <a href="<?php echo Url::url(Router::$path, "new/");?>" class="wojo small secondary button"><i class="icon plus alt"></i><?php echo Lang::$word->NW_SUB1;?></a> </div>
</div>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->NW_NONEWS;?></p>
</div>
<?php else:?>
<?php foreach ($this->data as $row):?>
<div class="wojo segment" id="item_<?php echo $row->id;?>">
  <div class="header">
    <div class="row horizontal-gutters">
      <div class="column shrink align-middle"><i class="icon huge disabled news"></i></div>
      <div class="column">
        <p class="wojo black small text"><?php echo Date::doDate("short_date", $row->created);?></p>
        <p><a class="wojo thick text" href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>"><?php echo $row->title;?></a></p>
        <p><small><?php echo Lang::$word->BY;?>: <?php echo $row->author;?></small></p>
      </div>
      <div class="column shrink align-top"> <a data-set='{"option":[{"trash": "trashNews","title": "<?php echo $row->title;?>","id":<?php echo $row->id;?>}],"action":"trash","parent":"#item_<?php echo $row->id;?>"}' class="wojo icon negative small button action"> <i class="icon trash"></i> </a> </div>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php endif;?>
<?php break;?>
<?php endswitch;?>