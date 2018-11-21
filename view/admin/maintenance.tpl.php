<?php
  /**
   * Maintenance
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: maintenance.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if (!Auth::checkAcl("owner")) : print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<h3><?php echo Lang::$word->META_T23;?></h3>
<p class="wojo small text"><?php echo Lang::$word->MT_INFO;?></p>
<form method="post" name="wojo_forma">
  <div class="wojo form segment">
    <div class="wojo fields">
      <div class="field three wide">
        <label><?php echo Lang::$word->MT_IUSERS;?></label>
        <select name="days" class="wojo small fluid secection dropdown">
          <option value="3">3</option>
          <option value="7">7</option>
          <option value="14">14</option>
          <option value="30">30</option>
          <option value="60">60</option>
          <option value="100">100</option>
          <option value="180">180</option>
          <option value="365">365</option>
        </select>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->DELETE;?></label>
        <button type="button" data-action="processMInactive" name="dosubmit" class="wojo small negative button"><?php echo Lang::$word->MT_IUBTN;?></button>
      </div>
    </div>
    <p class="wojo small text"><?php echo Lang::$word->MT_IUSERS_T;?></p>
  </div>
</form>
<form method="post" name="wojo_formb">
  <div class="wojo form segment">
    <div class="wojo fields">
      <div class="field three wide basic">
        <label><?php echo Lang::$word->MT_BUSERS;?></label>
        <p><?php echo str_replace("[TOTAL]", '<span class="wojo label" id="banned">' . $this->banned . '</span>', Lang::$word->MT_BUSERS_T);?></p>
      </div>
      <div class="field five wide basic">
        <label><?php echo Lang::$word->DELETE;?></label>
        <button type="button" data-action="processMIBanned" name="dosubmit" class="wojo small negative button"><?php echo Lang::$word->MT_BUBTN;?></button>
      </div>
    </div>
  </div>
</form>
<form method="post" name="wojo_formc">
  <div class="wojo form segment">
    <div class="wojo fields">
      <div class="field three wide basic">
        <label><?php echo Lang::$word->MT_CART;?></label>
        <p class="wojo small text"><?php echo Lang::$word->MT_CART_T;?></p>
      </div>
      <div class="field five wide basic">
        <label><?php echo Lang::$word->DELETE;?></label>
        <button type="button" data-action="processMCart" name="dosubmit" class="wojo small negative button"><?php echo Lang::$word->MT_CRBTN;?></button>
      </div>
    </div>
  </div>
</form>