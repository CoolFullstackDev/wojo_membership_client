<?php
  /**
   * My Account
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: myaccount.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Url::segment($this->segments)): case "password": ?>
<!-- Start password -->
<h3><?php echo Lang::$word->M_SUB2;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields align-middle">
      <div class="field four wide labeled">
        <label class="content-right mobile-content-left"><?php echo Lang::$word->NEWPASS;?> <i class="icon asterisk"></i></label>
      </div>
      <div class="field">
        <input type="text" name="password">
      </div>
    </div>
    <div class="wojo fields align-middle">
      <div class="field four wide labeled">
        <label class="content-right mobile-content-left"><?php echo Lang::$word->CONPASS;?> <i class="icon asterisk"></i></label>
      </div>
      <div class="field">
        <input type="text" name="password2">
      </div>
    </div>
  </div>
  <div class="content-center">
  <a href="<?php echo Url::url("/admin/myaccount");?>" class="wojo button"><?php echo Lang::$word->CANCEL;?></a>
    <button type="button" data-action="updatePassword" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->M_PASSUPDATE;?></button>
  </div>
</form>
<?php break;?>
<!-- Start default -->
<?php default: ?>
<h3><?php echo Lang::$word->M_TITLE;?></h3>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo basic segment form">
    <div class="row">
      <div class="mobile-100 columns mobile-order-2 padding">
        <div class="wojo fields align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->M_FNAME;?> <i class="icon asterisk"></i></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo $this->data->fname;?>" name="fname">
          </div>
        </div>
        <div class="wojo fields align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->M_LNAME;?> <i class="icon asterisk"></i></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo $this->data->lname;?>" name="lname">
          </div>
        </div>
        <div class="wojo fields align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->M_EMAIL;?> <i class="icon asterisk"></i></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo $this->data->email;?>" name="email">
          </div>
        </div>
        <div class="wojo fields disabled align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->CREATED;?></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo Date::doDate("short_date", $this->data->created);?>" readonly>
          </div>
        </div>
        <div class="wojo fields disabled align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->M_LASTLOGIN;?></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo Date::doDate("short_date", $this->data->lastlogin);?>">
          </div>
        </div>
        <div class="wojo fields disabled align-middle">
          <div class="field four wide labeled">
            <label class="content-right mobile-content-left"><?php echo Lang::$word->M_LASTIP;?></label>
          </div>
          <div class="field">
            <input type="text" value="<?php echo $this->data->lastip;?>">
          </div>
        </div>
      </div>
      <div class="shrink columns mobile-100 mobile-order-1 screen-left-divider tablet-left-divider padding">
        <input type="file" name="avatar" data-type="image" data-exist="<?php echo ($this->data->avatar) ? UPLOADURL . '/avatars/' . $this->data->avatar : UPLOADURL . '/avatars/blank.png';?>" accept="image/png, image/jpeg">
      </div>
    </div>
  </div>
  <div class="content-center">
    <button type="button" data-action="updateAccount" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->M_UPDATE;?></button>
  </div>
</form>
<?php break;?>
<?php endswitch;?>