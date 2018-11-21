<?php
  /**
   * Edit Role
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: editRole.tpl.php, v1.00 2016-03-02 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo small form content">
  <form method="post" id="modal_form" name="modal_form">
    <div class="wojo block fields">
      <div class="field">
        <label><?php echo Lang::$word->NAME;?></label>
        <input type="text" value="<?php echo $this->data->name;?>" name="name">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->DESCRIPTION;?></label>
        <textarea  name="description"><?php echo $this->data->description;?></textarea>
      </div>
    </div>
  </form>
</div>