<?php
  /**
   * Rename File
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: renameFile.tpl.php, v1.00 2016-03-02 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!$this->data) : Message::invalid("ID" . Filter::$id); return; endif;
?>
<div class="wojo small form content">
  <form method="post" id="modal_form" name="modal_form">
    <div class="content-center">
      <p><i class="big circular icon positive pencil"></i></p>
      <p class="wojo small bold text half-vertical-margin"><?php echo Lang::$word->NAME;?>: <?php echo $this->data->name;?></p>
    </div>
    <div class="wojo block fields">
      <div class="field">
        <label><?php echo Lang::$word->FM_ALIAS;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->FM_ALIAS;?>" value="<?php echo $this->data->alias;?>" name="alias">
      </div>
      <div class="basic field">
        <label><?php echo Lang::$word->FM_MACCESS;?> </label>
        <select name="fileaccess[]" class="wojo fluid multiple dropdown selection" multiple>
          <?php echo Utility::loopOptionsMultiple($this->mlist, "id", "title", $this->data->fileaccess);?>
        </select>
      </div>
    </div>
  </form>
</div>