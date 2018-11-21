<?php
  /**
   * Index
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: index.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if (isset($_POST['login'])):
      if (App::Auth()->login($_POST['email'], $_POST['password'])):
          Url::redirect(SITEURL . '/dashboard/');
      endif;
  endif;
?>
<div id="login-wrap">
  <div class="clearfix" id="tabs"><a class="active"> <?php echo Lang::$word->M_SUB16;?></a> <a class="static" href="<?php echo Url::url("/register");?>"><?php echo Lang::$word->M_SUB17;?></a></div>
  <div class="login-form">
    <div class="wojo form" id="loginform">
      <form method="post" id="login_form" name="wojo_form">
        <div class="wojo block fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" name="email">
          </div>
          <div class="field">
            <input type="password" placeholder="<?php echo Lang::$word->M_PASSWORD;?>" name="password">
          </div>
        </div>
        <div class="content-center">
          <div class="horizontal-padding">
            <button class="wojo fluid rounded big secondary button" name="login" type="submit"><span class="wojo bold small caps text"><?php echo Lang::$word->M_SUB16;?></span></button>
          </div>
          <div class="wojo space divider"></div>
          <a class="inverted" id="passreset"><?php echo Lang::$word->M_PASSWORD_L;?></a> </div>
      </form>
    </div>
    <div class="wojo form hide-all" id="passform">
      <form method="post" id="pass_form" name="wojo_form">
        <div class="wojo block fields">
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL;?>" name="pemail">
          </div>
          <div class="field">
            <input type="text" placeholder="<?php echo Lang::$word->M_FNAME;?>" name="fname">
          </div>
        </div>
        <div class="content-center">
          <div class="horizontal-padding">
            <button class="wojo fluid rounded big negative button" name="passreset" type="button"><span class="wojo bold small caps text"><?php echo Lang::$word->SUBMIT;?></span></button>
          </div>
          <div class="wojo space divider"></div>
          <a class="inverted" id="backto"><?php echo Lang::$word->M_SUB14;?></a> </div>
      </form>
    </div>
  </div>
  <div id="message-box"><?php print Message::$showMsg;?> </div>
</div>