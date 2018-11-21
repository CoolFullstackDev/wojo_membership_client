<?php
  /**
   * User Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: _users_edit.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<h3><?php echo Lang::$word->META_T3;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_FNAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->M_FNAME;?>" value="<?php echo $this->data->fname;?>" name="fname">
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->M_LNAME;?> <i class="icon asterisk"></i></label>
        <div class="wojo input">
          <input type="text" placeholder="<?php echo Lang::$word->M_LNAME;?>" value="<?php echo $this->data->lname;?>" name="lname">
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_EMAIL;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" value="<?php echo $this->data->email;?>" name="email">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->NEWPASS;?></label>
        <div class="wojo input action">
          <input type="text" name="password">
          <button class="wojo icon button" type="button" id="randPass"> <i class="lock icon"></i> </button>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_SUB8;?> </label>
        <div class="row align-middle">
          <div class="column">
            <select name="membership_id" class="wojo fluid dropdown selection">
              <option value="0">-/-</option>
              <?php echo Utility::loopOptions($this->mlist, "id", "title", $this->data->membership_id);?>
            </select>
          </div>
          <div class="column shrink half-left-padding">
            <div class="wojo small slider checkbox">
              <input name="update_membership" type="checkbox" value="1">
              <label><?php echo Lang::$word->YES;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->M_SUB15;?></label>
        <div class="row align-middle">
          <div class="column">
            <div class="wojo fluid calendar left icon  input" data-datepicker="true">
              <input name="mem_expire" type="text" placeholder="<?php echo Lang::$word->TO;?>">
              <i class="icon date"></i> </div>
          </div>
          <div class="column shrink half-left-padding">
            <div class="wojo small slider checkbox">
              <input name="extend_membership" type="checkbox" value="1">
              <label><?php echo Lang::$word->YES;?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo secondary boxed segment">
      <h5><?php echo Lang::$word->CSF_TITLE;?></h5>
      <div class="wojo space divider"></div>
      <?php echo $this->custom_fields;?></div>
    <a class="wojo left floating tiny icon button" data-trigger="#uAddress" data-type="slideDown" data-velocity="true" ><i class="icon chevron down"></i></a>
    <div class="wojo primary boxed bg padding-top padding-right padding-left hide-all" id="uAddress">
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
          <label class="content-right mobile-content-left"><?php echo Lang::$word->M_COUNTRY;?>/<?php echo Lang::$word->M_ZIP;?></label>
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
    </div>
    <div class="wojo big space divider"></div>
    <div class="wojo fields">
      <div class="field four wide">
        <div class="field">
          <label class="inverted"><?php echo Lang::$word->CREATED;?></label>
          <?php echo Date::doDate("long_date", $this->data->created);?> </div>
        <div class="field">
          <label class="inverted"><?php echo Lang::$word->M_LASTLOGIN;?></label>
          <?php echo $this->data->lastlogin ? Date::doDate("long_date", $this->data->lastlogin) : Lang::$word->NEVER;?> </div>
        <div class="field">
          <label class="inverted"><?php echo Lang::$word->M_LASTIP;?></label>
          <?php echo $this->data->lastip;?> </div>
      </div>
      <div class="field six wide">
        <div class="fitted field">
          <label><?php echo Lang::$word->STATUS;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="y" <?php Validator::getChecked($this->data->active, "y"); ?>>
              <label><?php echo Lang::$word->ACTIVE;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="n" <?php Validator::getChecked($this->data->active, "n"); ?>>
              <label><?php echo Lang::$word->INACTIVE;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="t" <?php Validator::getChecked($this->data->active, "t"); ?>>
              <label><?php echo Lang::$word->PENDING;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="active" type="radio" value="b" <?php Validator::getChecked($this->data->active, "b"); ?>>
              <label><?php echo Lang::$word->BANNED;?></label>
            </div>
          </div>
        </div>
        <div class="fitted field">
          <label><?php echo Lang::$word->M_SUB9;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox radio field">
              <input name="type" type="radio" value="staff" <?php Validator::getChecked($this->data->type, "staff"); ?>>
              <label><?php echo Lang::$word->STAFF;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="type" type="radio" value="editor" <?php Validator::getChecked($this->data->type, "editor"); ?>>
              <label><?php echo Lang::$word->EDITOR;?></label>
            </div>
            <div class="wojo checkbox radio field">
              <input name="type" type="radio" value="member" <?php Validator::getChecked($this->data->type, "member"); ?>>
              <label><?php echo Lang::$word->MEMBER;?></label>
            </div>
          </div>
        </div>
        <div class="fitted field">
          <label><?php echo Lang::$word->M_SUB10;?></label>
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
    </div>
    <textarea placeholder="<?php echo Lang::$word->M_SUB11;?>" name="notes"><?php echo $this->data->notes;?></textarea>
  </div>
  <div class="content-center"> <a href="<?php echo Url::url("/admin/users");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="processUser" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->M_UPDATE;?></button>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id;?>">
</form>