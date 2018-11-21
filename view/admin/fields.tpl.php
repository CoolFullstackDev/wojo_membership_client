<?php
  /**
   * Custom Fields
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: fields.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_fields')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<?php switch(Url::segment($this->segments)): case "edit": ?>
<!-- Start edit -->
<h3><?php echo Lang::$word->META_T16;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->NAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->NAME;?>" value="<?php echo $this->data->title;?>" name="title">
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CF_TIP;?></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->CF_TIP;?>" value="<?php echo $this->data->tooltip;?>" name="tooltip">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
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
      <div class="field five wide">
        <label><?php echo Lang::$word->CF_REQUIRED;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="required" type="radio" value="1" <?php Validator::getChecked($this->data->required, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="required" type="radio" value="0" <?php Validator::getChecked($this->data->required, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/fields");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processField" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->CF_UPDATE;?></button>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id;?>">
</form>
<?php break;?>
<?php case "new": ?>
<h3><?php echo Lang::$word->META_T17;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->NAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->NAME;?>" name="title">
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CF_TIP;?></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->CF_TIP;?>" name="tooltip">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
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
      <div class="field five wide">
        <label><?php echo Lang::$word->CF_REQUIRED;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="required" type="radio" value="1" checked="checked">
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="required" type="radio" value="0">
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/fields");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processField" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->CF_ADD;?></button>
  </div>
</form>
<?php break;?>
<?php default: ?>
<div class="row half-gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->CF_TITLE;?></h3>
    <p class="wojo small text"><?php echo Lang::$word->CF_INFO;?></p>
  </div>
  <div class="column shrink mobile-100 phone-100"> <a href="<?php echo Url::url(Router::$path, "new/");?>" class="wojo small secondary button"><i class="icon plus alt"></i><?php echo Lang::$word->CF_ADD;?></a> </div>
</div>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->CF_NOFIELDS;?></p>
</div>
<?php else:?>
<div class="wojo big space divider"></div>
<div class="row screen-block-3 tablet-block-2 mobile-block-1 phone-block-1 gutters align-center" id="sortable">
  <?php foreach ($this->data as $row):?>
  <div class="column" id="item_<?php echo $row->id;?>" data-id="<?php echo $row->id;?>">
    <div class="wojo boxed attached segment">
      <div class="wojo top left simple attached label"><i class="icon reorder link"></i></div>
      <div class="wojo bottom right attached simple label icon"> <a data-set='{"option":[{"delete": "deleteField","title": "<?php echo $row->title;?>","id":<?php echo $row->id;?>}],"action":"delete","parent":"#item_<?php echo $row->id;?>"}' class="action"> <i class="icon negative trash"></i> </a></div>
      <h5 class="content-center"><a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="inverted"><?php echo $row->title;?></a></h5>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/sortable.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function() {
    $("#sortable").sortable({
        ghostClass: "ghost",
        handle: ".label",
        animation: 600,
        onUpdate: function(e) {
            var order = this.toArray();
            $.ajax({
                type: 'post',
                url: "<?php echo ADMINVIEW . '/helper.php';?>",
                dataType: 'json',
                data: {
                    sortFields: 1,
                    sorting: order
                }
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>