<?php
  /**
   * Mailer
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: mailer.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_newsletter')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<h3><?php echo Lang::$word->META_T24;?></h3>
<p class="wojo small text"><?php echo Lang::$word->NL_INFO1;?></p>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide disabled">
        <label><?php echo Lang::$word->NL_FROM;?></label>
        <input type="text" disabled placeholder="<?php echo Lang::$word->NL_FROM;?>" value="<?php echo App::Core()->site_email;?>" name="site_email">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->NL_RCPT;?> <i class="icon asterisk"></i></label>
        <?php if(Validator::get('email')):?>
        <input type="text" placeholder="<?php echo Lang::$word->NL_RCPT;?>" value="<?php echo Validator::get('email');?>" readonly name="recipient">
        <?php else:?>
        <select name="recipient" class="wojo fluid selection dropdown">
          <option value="all"><?php echo Lang::$word->NL_UALL;?></option>
          <option value="free"><?php echo Lang::$word->NL_UAREG;?></option>
          <option value="paid"><?php echo Lang::$word->NL_UPAID;?></option>
          <option value="newsletter"><?php echo Lang::$word->NL_UNLS;?></option>
        </select>
        <?php endif;?>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->NL_SUBJECT;?></label>
        <input type="text" placeholder="<?php echo Lang::$word->NL_SUBJECT;?>" value="<?php echo $this->data->subject;?>" name="subject">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->NL_ATTACH;?></label>
        <input type="file" name="attachment" id="attachment" class="filefield">
      </div>
    </div>
    <div class="field">
      <label><?php echo Lang::$word->NL_BODY;?></label>
      <textarea name="body" class="bodypost"><?php echo str_replace("[SITEURL]", SITEURL, $this->data->body);?></textarea>
      <p class="column wojo small negative text half-left-padding"> <?php echo Lang::$word->NOTEVAR;?></p>
    </div>
  </div>
  <div class="content-center">
    <button type="button" data-action="processMailer" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->NL_SEND;?></button>
  </div>
</form>