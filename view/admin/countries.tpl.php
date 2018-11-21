<?php
  /**
   * Countries
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: countries.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_email')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<?php switch(Url::segment($this->segments)): case "edit": ?>
<!-- Start edit -->
<h3><?php echo Lang::$word->CNT_EDIT;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->NAME;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->NAME;?>" value="<?php echo $this->data->name;?>" name="name">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CNT_ABBR;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->CNT_ABBR;?>" value="<?php echo $this->data->abbr;?>" name="abbr">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->TRX_TAX;?></label>
        <div class="wojo right labeled input">
          <input type="text" placeholder="<?php echo Lang::$word->TRX_TAX;?>" value="<?php echo $this->data->vat;?>" name="vat">
          <div class="wojo label">%</div>
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->SORTING;?></label>
        <input type="text" placeholder="<?php echo Lang::$word->SORTING;?>" value="<?php echo $this->data->sorting;?>" name="sorting">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <div class="fitted field">
          <label><?php echo Lang::$word->STATUS;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="1" <?php Validator::getChecked($this->data->active, 1); ?>>
              <label><?php echo Lang::$word->ACTIVE;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="0" <?php Validator::getChecked($this->data->active, 0); ?>>
              <label><?php echo Lang::$word->INACTIVE;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="field five wide">
        <div class="fitted field">
          <label><?php echo Lang::$word->DEFAULT;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox radio field">
              <input name="home" type="radio" value="1" <?php Validator::getChecked($this->data->home, 1); ?>>
              <label><?php echo Lang::$word->YES;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="home" type="radio" value="0" <?php Validator::getChecked($this->data->home, 0); ?>>
              <label><?php echo Lang::$word->NO;?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/countries");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processCountry" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->CNT_UPDATE;?></button>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id;?>">
</form>
<?php break;?>
<?php default: ?>
<h3><?php echo Lang::$word->CNT_TITLE;?></h3>
<p class="wojo small text"><?php echo Lang::$word->CNT_INFO;?></p>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->CNT_NOCOUNTRY;?></p>
</div>
<?php else:?>
<div class="wojo segment">
  <table class="wojo sorting basic table" id="editable">
    <thead>
      <tr>
        <th class="disabled center aligned"><i class="icon disabled id"></i></th>
        <th data-sort="string"><?php echo Lang::$word->NAME;?></th>
        <th data-sort="string"><?php echo Lang::$word->CNT_ABBR;?></th>
        <th data-sort="int"><?php echo Lang::$word->TRX_TAX;?></th>
        <th data-sort="int"><?php echo Lang::$word->SORTING;?></th>
        <th class="disabled center aligned"><?php echo Lang::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <?php foreach ($this->data as $row):?>
    <tr id="item_<?php echo $row->id;?>">
      <td class="collapsing"><span class="wojo mini basic disabled label"><?php echo $row->id;?></span></td>
      <td><a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="inverted"> <?php echo $row->name;?></a></td>
      <td><span class="wojo small label"><?php echo $row->abbr;?></span></td>
      <td><span data-editable="true" data-set='{"type": "tax", "id": <?php echo $row->id;?>,"key":"<?php echo $row->vat;?>"}'><?php echo $row->vat;?></span>%</td>
      <td><?php echo $row->sorting;?></td>
      <td class="collapsing"><a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="wojo icon circular basic positive button"><i class="icon positive note"></i></a></td>
    </tr>
    <?php endforeach;?>
  </table>
</div>
<?php endif;?>
<?php break;?>
<?php endswitch;?>