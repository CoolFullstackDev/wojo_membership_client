<?php
  /**
   * Register
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: register.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div id="login-wrap">
  <div class="clearfix" id="tabs"><a href="<?php echo Url::url('');?>" class="static">
      <?php echo Lang::$word->M_SUB16;?></a>
    <a class="active"><?php echo Lang::$word->M_SUB17;?></a>
  </div>
  <div class="login-form">
    <form method="post" id="wojo_form" name="wojo_form">
      <div class="wojo form">
        <div class="wojo block fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" name="email">
          </div>
          <div class="field">
            <input type="password" placeholder="<?php echo Lang::$word->M_PASSWORD;?>" name="password">
          </div>
        </div>
        <div class="wojo fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_FNAME;?>" name="fname">
          </div>
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_LNAME;?>" name="lname">
          </div>
        </div>
        <?php echo $this->custom_fields;?>
        <?php if(App::Core()->enable_tax):?>
        <div class="wojo block fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_ADDRESS;?>" name="address">
          </div>
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_CITY;?>" name="city">
          </div>
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_STATE;?>" name="state">
          </div>
          <div class="field">
            <div class="wojo action input">
              <input type="text" placeholder="<?php echo Lang::$word->M_ZIP;?>" name="zip">
              <select class="wojo search selection dropdown" name="country">
                <?php echo Utility::loopOptions($this->clist, "abbr", "name");?>
              </select>
            </div>
          </div>
        </div>
        <?php endif;?>
        <div class="wojo block fields">
          <div class="field">
            <div class="wojo right labeled input">
              <input name="captcha" placeholder="<?php echo Lang::$word->CAPTCHA;?>" type="text">
              <div class="wojo basic label"><img src="<?php echo SITEURL;?>/captcha.php" alt="" style="height:25px"></div>
            </div>
          </div>
        </div>
        <div class="wojo block fields">
          <div class="field">
            <div class="wojo checkbox checkbox">
              <input name="agree" type="checkbox" value="1">
              <label><a href="<?php echo Url::url("/privacy");?>"><?php echo Lang::$word->AGREE;?></a>
              </label>
            </div>
          </div>
        </div>
        <div class="content-center">
          <div class="horizontal-padding">
            <button class="wojo fluid rounded big secondary button" data-action="register" name="dosubmit" type="button"><span class="wojo bold small caps text"><?php echo Lang::$word->M_SUB17;?></span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
