<?php
  /**
   * Profile
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: profile.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="content-center"><img src="<?php echo UPLOADURL;?>/avatars/<?php echo (App::Auth()->avatar) ? App::Auth()->avatar : "blank.png";?>" alt="" class="avatar"></div>
<div class="wojo big space divider"></div>
<div class="clearfix" id="tabs-alt"> <a href="<?php echo Url::url("/dashboard");?>" class="static"> <?php echo Lang::$word->ADM_MEMBS;?></a> <a href="<?php echo Url::url("/dashboard/history");?>" class="static"><?php echo Lang::$word->HISTORY;?></a> <a class="active"><?php echo Lang::$word->M_SUB18;?></a> <a class="static" href="<?php echo Url::url("/dashboard/downloads");?>"><?php echo Lang::$word->DOWNLOADS;?></a></div>
<div class="login-form">
  <form method="post" id="wojo_form" name="wojo_form">
    <div class="wojo form">
      <input type="file" name="avatar" data-type="image" data-exist="<?php echo ($this->data->avatar) ? UPLOADURL . '/avatars/' . $this->data->avatar : UPLOADURL . '/avatars/blank.png';?>" accept="image/png, image/jpeg">
      <div class="wojo big space divider"></div>
      <div class="wojo fields">
        <div class="field five wide">
          <label><?php echo Lang::$word->M_FNAME;?> <i class="icon asterisk"></i></label>
          <input type="text" placeholder="<?php echo Lang::$word->M_FNAME;?>" value="<?php echo $this->data->fname;?>" name="fname">
        </div>
        <div class="field five wide">
          <label><?php echo Lang::$word->M_LNAME;?> <i class="icon asterisk"></i></label>
          <input type="text" placeholder="<?php echo Lang::$word->M_LNAME;?>" value="<?php echo $this->data->lname;?>" name="lname">
        </div>
      </div>
      <div class="wojo fields">
        <div class="field five wide">
          <label><?php echo Lang::$word->M_EMAIL;?> <i class="icon asterisk"></i></label>
          <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" value="<?php echo $this->data->email;?>" name="email">
        </div>
        <div class="field">
          <label><?php echo Lang::$word->NEWPASS;?></label>
          <input type="password" name="password">
        </div>
      </div>
      <?php if($this->custom_fields):?>
      <div class="wojo secondary boxed segment"> <?php echo $this->custom_fields;?></div>
      <?php endif;?>
      <?php if(App::Core()->enable_tax):?>
      <div class="wojo fields">
        <div class="field four wide labeled">
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_ADDRESS;?></label>
        </div>
        <div class="field">
          <input type="text" placeholder="<?php echo Lang::$word->M_ADDRESS;?>" value="<?php echo $this->data->address;?>" name="address">
        </div>
      </div>
      <div class="wojo fields">
        <div class="field four wide labeled">
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_CITY;?></label>
        </div>
        <div class="field">
          <input type="text" placeholder="<?php echo Lang::$word->M_CITY;?>" value="<?php echo $this->data->city;?>" name="city">
        </div>
      </div>
      <div class="wojo fields">
        <div class="field four wide labeled">
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_STATE;?></label>
        </div>
        <div class="field">
          <div class="wojo action input">
            <input type="text" placeholder="<?php echo Lang::$word->M_STATE;?>" value="<?php echo $this->data->state;?>" name="state">
          </div>
        </div>
      </div>
      <div class="wojo fields">
        <div class="field four wide labeled">
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_ZIP;?> / <?php echo Lang::$word->M_COUNTRY;?></label>
        </div>
        <div class="field">
          <div class="wojo action input">
            <input type="text" placeholder="<?php echo Lang::$word->M_ZIP;?>" value="<?php echo $this->data->zip;?>" name="zip">
            <select class="wojo search selection dropdown" name="country">
              <?php echo Utility::loopOptions($this->clist, "abbr", "name", $this->data->country);?>
            </select>
          </div>
        </div>
      </div>
      <div class="wojo space divider"></div>
      <?php endif;?>
      <div class="wojo fields">
        <div class="field four wide labeled">
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_SUB10;?></label>
        </div>
        <div class="field">
          <div class="wojo inline fields">
            <div class="wojo checkbox radio field">
              <input name="newsletter" type="radio" value="1" <?php Validator::getChecked($this->data->newsletter, 1); ?>>
              <label><?php echo Lang::$word->YES;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="newsletter" type="radio" value="0" <?php Validator::getChecked($this->data->newsletter, 0); ?>>
              <label><?php echo Lang::$word->NO;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="content-center">
        <button type="button" data-action="profile" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->M_UPDATE;?></button>
      </div>
    </div>
  </form>
</div>