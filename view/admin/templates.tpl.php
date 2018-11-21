<?php
  /**
   * Email Templates
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: templates.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_email')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<?php switch(Url::segment($this->segments)): case "edit": ?>
<!-- Start edit -->
<h3><?php echo Lang::$word->META_T11;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->ET_NAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->ET_NAME;?>" value="<?php echo $this->data->name;?>" name="name">
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->ET_SUBJECT;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->ET_SUBJECT;?>" value="<?php echo $this->data->subject;?>" name="subject">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="basic field">
        <textarea class="bodypost" name="body"><?php echo str_replace("[SITEURL]", SITEURL, $this->data->body);?></textarea>
        <div class="wojo space divider"></div>
        <div class="row align-middle"><i class="column shrink icon negative info sign"></i>
          <p class="column wojo small negative text half-left-padding"> <?php echo Lang::$word->NOTEVAR;?></p>
        </div>
      </div>
    </div>
    <div class="wojo divider"></div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->ET_DESC;?></label>
        <div class="wojo small input">
          <textarea class="small" placeholder="<?php echo Lang::$word->ET_DESC;?>" name="help"><?php echo $this->data->help;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/templates");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processTemplate" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->ET_UPDATE;?></button>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id;?>">
</form>
<?php break;?>
<?php default: ?>
<h3><?php echo Lang::$word->ET_TITLE;?></h3>
<p class="wojo small text"><?php echo Lang::$word->ET_SUB;?></p>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->ET_INFO;?></p>
</div>
<?php else:?>
<div class="wojo segment">
  <table class="wojo sorting basic table">
    <thead>
      <tr>
        <th class="disabled center aligned"><i class="icon disabled id"></i></th>
        <th data-sort="string"><?php echo Lang::$word->ET_NAME;?></th>
        <th data-sort="string"><?php echo Lang::$word->ET_SUBJECT;?></th>
        <th class="disabled center aligned"><?php echo Lang::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <?php foreach ($this->data as $row):?>
    <tr id="item_<?php echo $row->id;?>">
      <td class="collapsing"><span class="wojo mini basic disabled label"><?php echo $row->id;?></span></td>
      <td><a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="inverted"> <?php echo $row->name;?></a></td>
      <td><?php echo $row->subject;?></td>
      <td class="collapsing"><a href="<?php echo Url::url(Router::$path, "edit/" . $row->id);?>" class="wojo icon circular basic positive button"><i class="icon positive note"></i></a></td>
    </tr>
    <?php endforeach;?>
  </table>
</div>
<?php endif;?>
<?php break;?>
<?php endswitch;?>