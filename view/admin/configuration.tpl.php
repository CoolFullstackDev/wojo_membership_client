<?php
  /**
   * Configuration
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: configuration.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if (!Auth::checkAcl("owner")) : print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<h3><?php echo Lang::$word->META_T25;?></h3>
<p class="wojo small text"><?php echo Lang::$word->CG_INFO;?></p>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_SITENAME;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_SITENAME;?>" value="<?php echo $this->data->company;?>" name="company">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_WEBEMAIL;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_WEBEMAIL;?>" value="<?php echo $this->data->site_email;?>" name="site_email">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_DIR;?> </label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_DIR;?>" value="<?php echo $this->data->site_dir;?>" name="site_dir">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_WEBEMAIL1;?> </label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_WEBEMAIL1;?>" value="<?php echo $this->data->psite_email;?>" name="psite_email">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_LOGO;?> </label>
        <input type="file" name="logo" id="logo" class="filefield">
        <div class="wojo half-top-padding">
          <div class="wojo checkbox small checkbox">
            <input name="dellogo" type="checkbox" value="1">
            <label><?php echo Lang::$word->CG_LOGODEL;?></label>
          </div>
        </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_LOGO1;?> </label>
        <input type="file" name="plogo" id="plogo" class="filefield">
        <div class="wojo half-top-padding">
          <div class="wojo checkbox small checkbox">
            <input name="dellogop" type="checkbox" value="1">
            <label><?php echo Lang::$word->CG_LOGODEL;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_LONGDATE;?> <i class="icon asterisk"></i></label>
        <select name="long_date" class="wojo fluid dropdown">
          <?php echo Date::getLongDate($this->data->long_date);?>
        </select>
      </div>
      <div class="field three wide">
        <label><?php echo Lang::$word->CG_SHORTDATE;?> <i class="icon asterisk"></i></label>
        <select name="short_date" class="wojo fluid dropdown">
          <?php echo Date::getShortDate($this->data->short_date);?>
        </select>
      </div>
      <div class="field two wide">
        <label><?php echo Lang::$word->CG_TIMEFORMAT;?> <i class="icon asterisk"></i></label>
        <select name="time_format" class="wojo fluid dropdown">
          <?php echo Date::getTimeFormat($this->data->time_format);?>
        </select>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_WEEKSTART;?></label>
        <select name="weekstart" class="wojo fluid dropdown">
          <?php echo Date::weekList(true, true, $this->data->weekstart);?>
        </select>
      </div>
      <div class="field three wide">
        <label><?php echo Lang::$word->CG_LANG;?></label>
        <select name="lang" class="wojo fluid dropdown">
          <?php foreach(Lang::fetchLanguage() as $langlist):?>
          <option value="<?php echo substr($langlist, 0, 2);?>" <?php echo Validator::getSelected($this->data->lang, substr($langlist, 0, 2));?>><?php echo strtoupper(substr($langlist, 0, 2));?></option>
          <?php endforeach;?>
        </select>
      </div>
      <div class="field two wide">
        <label><?php echo Lang::$word->CG_PERPAGE;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_PERPAGE;?>" value="<?php echo $this->data->perpage;?>" name="perpage">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_DTZ;?></label>
        <select name="dtz" class="wojo fluid dropdown">
          <?php echo Date::getTimezones();?>
        </select>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->CG_LOCALES;?></label>
        <select name="locale" class="wojo fluid dropdown">
          <?php echo Date::localeList($this->data->locale);?>
        </select>
      </div>
    </div>
    <div class="wojo double fitted basic divider"></div>
    <div class="wojo space divider"></div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->CG_REGVERIFY;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="reg_verify" type="radio" value="1" <?php Validator::getChecked($this->data->reg_verify, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="reg_verify" type="radio" value="0" <?php Validator::getChecked($this->data->reg_verify, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->CG_AUTOVERIFY;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="auto_verify" type="radio" value="1" <?php Validator::getChecked($this->data->auto_verify, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="auto_verify" type="radio" value="0" <?php Validator::getChecked($this->data->auto_verify, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->CG_REGALOWED;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="reg_allowed" type="radio" value="1" <?php Validator::getChecked($this->data->reg_allowed, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="reg_allowed" type="radio" value="0" <?php Validator::getChecked($this->data->reg_allowed, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->CG_NOTIFY_ADMIN;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="notify_admin" type="radio" value="1" <?php Validator::getChecked($this->data->notify_admin, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="notify_admin" type="radio" value="0" <?php Validator::getChecked($this->data->notify_admin, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->CG_CURRENCY;?></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_CURRENCY;?>" value="<?php echo $this->data->currency;?>" name="currency">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->CG_ETAX;?></label>
        <div class="wojo inline fields">
          <div class="wojo checkbox small radio slider field">
            <input name="enable_tax" type="radio" value="1" <?php Validator::getChecked($this->data->enable_tax, 1); ?>>
            <label><?php echo Lang::$word->YES;?></label>
          </div>
          <div class="wojo checkbox small radio slider field">
            <input name="enable_tax" type="radio" value="0" <?php Validator::getChecked($this->data->enable_tax, 0); ?>>
            <label><?php echo Lang::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->CG_FILEDIR;?> <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_FILEDIR;?>" value="<?php echo $this->data->file_dir;?>" name="file_dir">
      </div>
      <div class="field"> </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_TWID;?></label>
        <div class="wojo icon input">
          <input type="text" placeholder="<?php echo Lang::$word->CG_TWID;?>" value="<?php echo $this->data->social->twitter;?>" name="twitter">
          <i class="icon twitter"></i> </div>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_FBID;?></label>
        <div class="wojo icon input">
          <input type="text" placeholder="<?php echo Lang::$word->CG_FBID;?>" value="<?php echo $this->data->social->facebook;?>" name="facebook">
          <i class="icon facebook"></i> </div>
      </div>
    </div>
    <div class="wojo double fitted basic divider"></div>
    <div class="wojo space divider"></div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_MEMBERSHIP;?> </label>
        <div class="wojo checkbox">
          <input name="enable_dmembership" type="checkbox" value="1" <?php Validator::getChecked($this->data->enable_dmembership, 1); ?>>
          <label><?php echo Lang::$word->YES;?></label>
        </div>
        <p class="wojo small positive text"><em><?php echo Lang::$word->CG_MEMBERSHIP_T;?></em></p>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->META_T29;?> </label>
        <select name="dmembership" class="wojo fluid dropdown selection">
          <option value="0">-/-</option>
          <?php echo Utility::loopOptions($this->mlist, "id", "title", $this->data->dmembership);?>
        </select>
      </div>
    </div>
    <div class="wojo double fitted basic divider"></div>
    <div class="wojo space divider"></div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_INVDATA;?> </label>
        <textarea class="altpost" name="inv_info"><?php echo $this->data->inv_info;?></textarea>
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_INVNOTE;?> </label>
        <textarea class="altpost" name="inv_note"><?php echo $this->data->inv_note;?></textarea>
      </div>
    </div>
    <div class="wojo double fitted basic divider"></div>
    <div class="wojo space divider"></div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->CG_OFFLINE;?></label>
        <textarea class="altpost" name="offline_info"><?php echo $this->data->offline_info;?></textarea>
      </div>
    </div>
    <div class="wojo double fitted basic divider"></div>
    <div class="wojo space divider"></div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->CG_MAILER;?></label>
        <select name="mailer" id="mailerchange" class="wojo fluid dropdown">
          <option value="PHP" <?php echo Validator::getSelected($this->data->mailer, "PHP");?>>PHP Mailer</option>
          <option value="SMAIL" <?php echo Validator::getSelected($this->data->mailer, "SMAIL");?>>Sendmail</option>
          <option value="SMTP" <?php echo Validator::getSelected($this->data->mailer, "SMTP");?>>SMTP Mailer</option>
        </select>
      </div>
      <div class="field showsmail">
        <label><?php echo Lang::$word->CG_SMAILPATH;?></label>
        <input type="text" placeholder="<?php echo Lang::$word->CG_SMAILPATH;?>" value="<?php echo $this->data->sendmail;?>" name="sendmail">
      </div>
    </div>
    <div class="showsmtp">
      <div class="wojo fields">
        <div class="field five wide">
          <label><?php echo Lang::$word->CG_SMTP_HOST;?> <i class="icon asterisk"></i></label>
          <input type="text" placeholder="<?php echo Lang::$word->CG_SMTP_HOST;?>" value="<?php echo $this->data->smtp_host;?>" name="smtp_host">
        </div>
        <div class="field five wide">
          <label><?php echo Lang::$word->CG_SMTP_USER;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->CG_SMTP_USER;?>" value="<?php echo $this->data->smtp_user;?>" name="smtp_user">
        </div>
      </div>
      <div class="wojo fields">
        <div class="field three wide">
          <label><?php echo Lang::$word->CG_SMTP_PASS;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->CG_SMTP_PASS;?>" value="<?php echo $this->data->smtp_pass;?>" name="smtp_pass">
        </div>
        <div class="field three wide">
          <label><?php echo Lang::$word->CG_SMTP_PORT;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->CG_SMTP_PORT;?>" value="<?php echo $this->data->smtp_port;?>" name="smtp_port">
        </div>
        <div class="field four wide">
          <label><?php echo Lang::$word->CG_SMTP_SSL;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox radio small slider field">
              <input name="is_ssl" type="radio" value="1" <?php Validator::getChecked($this->data->is_ssl, 1); ?>>
              <label><?php echo Lang::$word->YES;?></label>
            </div>
            <div class="wojo checkbox radio small slider field">
              <input name="is_ssl" type="radio" value="0" <?php Validator::getChecked($this->data->is_ssl, 0); ?>>
              <label><?php echo Lang::$word->NO;?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-center">
    <button type="button" data-action="processConfig" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->CG_UPDATE;?></button>
  </div>
</form>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
     var res2 = '<?php echo $this->data->mailer;?>';
	 $('.showsmtp').velocity(res2 == "SMTP" ? 'slideDown' : 'slideUp');
     $('#mailerchange').change(function () {
         var res = $("#mailerchange option:selected").val();
		 $('.showsmtp').velocity(res == "SMTP" ? 'slideDown' : 'slideUp');
     });

	 $('.showsmail').velocity(res2 == "SMAIL" ? 'slideDown' : 'slideUp');
     $('#mailerchange').change(function () {
         var res = $("#mailerchange option:selected").val();
		 $('.showsmail').velocity(res == "SMAIL" ? 'slideDown' : 'slideUp');
     });
});
// ]]>
</script>