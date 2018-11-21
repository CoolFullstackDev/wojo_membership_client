<?php
  /**
   * Contact
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: contact.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="row align-center">
  <div class="column screen-70 tablet-100 mobile-100 phone-100">
    <h1><?php echo Lang::$word->META_T30;?></h1>
    <form method="post" id="wojo_form" name="wojo_form">
      <div class="wojo segment form">
        <p><?php echo Lang::$word->CNT_INFO;?></p>
        <div class="wojo big space divider"></div>
        <div class="wojo block fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->CNT_NAME;?>" value="<?php echo (App::Auth()->logged_in) ? App::Auth()->name : null;?>" name="name">
          </div>
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" value="<?php echo (App::Auth()->logged_in) ? App::Auth()->email : null;?>" name="email">
          </div>
          <div class="field">
            <select name="subject" class="wojo fluid dropdown">
              <option value=""><?php echo Lang::$word->CNT_SUBJECT_1;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_2;?>"><?php echo Lang::$word->CNT_SUBJECT_2;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_3;?>"><?php echo Lang::$word->CNT_SUBJECT_3;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_4;?>"><?php echo Lang::$word->CNT_SUBJECT_4;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_5;?>"><?php echo Lang::$word->CNT_SUBJECT_5;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_6;?>"><?php echo Lang::$word->CNT_SUBJECT_6;?></option>
              <option value="<?php echo Lang::$word->CNT_SUBJECT_7;?>"><?php echo Lang::$word->CNT_SUBJECT_7;?></option>
            </select>
          </div>
          <div class="field">
            <textarea placeholder="<?php echo Lang::$word->MESSAGE;?>" name="notes"></textarea>
          </div>
          <div class="field">
            <div class="wojo right labeled input">
              <input name="captcha" placeholder="<?php echo Lang::$word->CAPTCHA;?>" type="text">
              <div class="wojo basic label"><img src="<?php echo SITEURL;?>/captcha.php" alt="" style="height:25px"></div>
            </div>
          </div>
        </div>
        <div class="content-center">
          <div class="horizontal-padding">
            <button class="wojo fluid rounded big secondary button" data-action="contact" name="dosubmit" type="button"><span class="wojo bold small caps text"><?php echo Lang::$word->CNT_SUBMIT;?></span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>