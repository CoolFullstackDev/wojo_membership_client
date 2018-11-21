<?php
  /**
   * Login Page
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: login.tpl.php, v1.00 2015-10-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  if (isset($_POST['submit'])):
      if (App::Auth()->login($_POST['username'], $_POST['password'])):
          Url::redirect(SITEURL . '/admin/');
      endif;
  endif;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="<?php echo ADMINVIEW;?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMINVIEW;?>/css/icon.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMINVIEW;?>/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/global.js"></script>
</head>
<body>
<div id="container">
  <div class="card">
    <h1 class="title"><?php echo Utility::sayHello();?> <?php echo Lang::$word->GUEST;?>!</h1>
    <form id="admin_form" name="admin_form" method="post">
      <div id="loginform">
        <div class="input-container">
          <input  name="username" id="Username">
          <label for="Username"><?php echo Lang::$word->USERNAME;?></label>
          <div class="bar"></div>
        </div>
        <div class="input-container">
          <input type="password" name="password" id="Password">
          <label for="Password"><?php echo Lang::$word->M_PASSWORD;?></label>
          <div class="bar"></div>
        </div>
        <div class="button-container">
          <button name="submit" class="button-login"><?php echo Lang::$word->LOGIN;?></button>
        </div>
        <div class="footer"><a id="passreset"><?php echo Lang::$word->M_PASSWORD_RES;?></a></div>
      </div>
      <div id="passform" style="display:none">
        <div class="input-container">
          <input name="fname" id="pUsername">
          <label for="pUsername"><?php echo Lang::$word->M_FNAME;?></label>
          <div class="bar"></div>
        </div>
        <div class="input-container">
          <input name="email" id="pEmail">
          <label for="pEmail"><?php echo Lang::$word->M_EMAIL;?></label>
          <div class="bar"></div>
        </div>
        <div class="button-container">
          <button id="dopass" type="button" name="dopass" class="alt"><?php echo Lang::$word->SUBMIT;?></button>
        </div>
        <div class="footer"><a id="backto"><?php echo Lang::$word->M_SUB14;?></a></div>
      </div>
      <div id="message-box"><?php print Message::$showMsg;?> </div>
    </form>
  </div>
</div>
<footer> Copyright &copy;<?php echo date('Y') . ' '. App::Core()->company;?> </footer>
<script type="text/javascript">
$(document).ready(function() {
    $("#backto").on('click', function() {
        $("#loginform").velocity("slideDown");
        $("#passform").velocity("slideUp");
    });
    $("#passreset").on('click', function() {
        $("#loginform").velocity("slideUp");
        $("#passform").velocity("slideDown");
    });
	
    $("#dopass").on('click', function() {
        var $btn = $(this);
        $btn.addClass('loading');
        var email = $("input[name=email]").val();
        var fname = $("input[name=fname]").val();
        $.ajax({
            type: 'post',
            url: "<?php echo FRONTVIEW;?>/controller.php",
            data: {
                'action': 'aResetPass',
                'email': email,
                'fname': fname
            },
            dataType: "json",
            success: function(json) {
                if (json.type === "success") {
					$("#passform .input-container").removeClass('error');
					$btn.replaceWith(json.message);
                } else {
					$("#passform .input-container").addClass('error');
				}
                $btn.removeClass('loading');
            }
        });
    });
});
</script>
</body>
</html>