<?php
  /**
   * Authorize.Net Form
   *
   * @package Car Delaer Pro
   * @author wojoscripts.com
   * @copyright 2015
   * @version $Id: form.tpl.php, v3.00 2015-03-20 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
  
  $months = array();
  
  for ($i = 1; $i <= 12; $i++) {
      $months[] = array(
		  'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)), 
		  'value' => sprintf('%02d', $i)
	  );
  }
  
  $today = getdate();
  $year_expire = array();
  
  for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
      $year_expire[] = array(
		  'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)), 
		  'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
	  );
  }
?>
<div class="wojo small secondary segment form">
  <form method="post" id="an_form" name="an_form">
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->M_FNAME;?></label>
        <input type="text" name="fname" value="<?php echo Auth::$userdata->fname;?>" placeholder="First Name">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->M_LNAME;?></label>
        <input type="text" name="lname" value="<?php echo Auth::$userdata->lname;?>" placeholder="Last Name">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->M_ADDRESS;?></label>
        <input type="text" name="address" value="<?php echo Auth::$userdata->address;?>" placeholder="Address">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->M_CITY;?></label>
        <input type="text" name="city" value="<?php echo Auth::$userdata->city;?>" placeholder="City">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->M_COUNTRY;?></label>
        <select name="country" class="wojo fluid dropdown">
          <option value="">-- <?php echo Lang::$word->CNT_SELECT;?> --</option>
          <?php echo Utility::loopOptions(App::Content()->getCountryList(), "abbr", "name", Auth::$userdata->country);?>
        </select>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->M_EMAIL;?></label>
        <input type="text" name="email" value="<?php echo Auth::$userdata->email;?>" placeholder="Email Address">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->M_ZIP;?></label>
        <input type="text" name="zip" value="<?php echo Auth::$userdata->zip;?>" placeholder="Zip/Postal Code">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->M_STATE;?></label>
        <select name="state" id="state" class="wojo fluid dropdown">
          <option value="">--- Select State/Province ---</option>
          <option value="AB">Alberta</option>
          <option value="BC">British Columbia</option>
          <option value="MB">Manitoba</option>
          <option value="NB">New Brunswick</option>
          <option value="NF">Newfoundland</option>
          <option value="NT">Northwest Territories</option>
          <option value="NS">Nova Scotia</option>
          <option value="NVT">Nunavut</option>
          <option value="ON">Ontario</option>
          <option value="PE">Prince Edward Island</option>
          <option value="QC">Quebec</option>
          <option value="SK">Saskatchewan</option>
          <option value="YK">Yukon</option>
          <option value="AL">Alabama</option>
          <option value="AK">Alaska</option>
          <option value="AZ">Arizona</option>
          <option value="AR">Arkansas</option>
          <option value="BVI">British Virgin Islands</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="GU">Guam</option>
          <option value="HI">Hawaii</option>
          <option value="ID">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="ME">Maine</option>
          <option value="MP">Mariana Islands</option>
          <option value="MPI">Mariana Islands (Pacific)</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Missouri</option>
          <option value="MT">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NV">Nevada</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="PR">Puerto Rico</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VT">Vermont</option>
          <option value="USVI">VI  U.S. Virgin Islands</option>
          <option value="VA">Virginia</option>
          <option value="WA">Washington</option>
          <option value="DC">Washington, D.C.</option>
          <option value="WV">West Virginia</option>
          <option value="WI">Wisconsin</option>
          <option value="WY">Wyoming</option>
          <option value="N/A">Other</option>
        </select>
      </div>
    </div>
    <div class="wojo divider"></div>
    <div class="wojo fields">
      <div class="field">
        <label>Select One</label>
        <div class="wojo inline fields">
          <div class="wojo checkbox radio field">
            <input type="radio" name="cctype" value="V">
            <label><img src="<?php echo SITEURL;?>/gateways/anet/vs.png" alt=""></label>
          </div>
          <div class="wojo checkbox radio field">
            <input type="radio" name="cctype" value="M">
            <label><img src="<?php echo SITEURL;?>/gateways/anet/mc.png" alt=""></label>
          </div>
          <div class="wojo checkbox radio field">
            <input type="radio" name="cctype" value="A">
            <label><img src="<?php echo SITEURL;?>/gateways/anet/ae.png" alt=""></label>
          </div>
          <div class="wojo checkbox radio field">
            <input type="radio" name="cctype" value="D">
            <label><img src="<?php echo SITEURL;?>/gateways/anet/dc.png" alt=""></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->STR_CCN;?></label>
        <input type="text" name="ccn" placeholder="Card Number">
      </div>
      <div class="field">
        <label>Name On Card</label>
        <input type="text" name="ccname" placeholder="Name On Card">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->STR_CCV;?> <i class="icon question sign" data-content="For Visa, MasterCard, and Discover cards, the card code is the last 3 digit number located on the back of your card on or above your signature line. For an American Express card, it is the 4 digits on the FRONT above the end of your card number"></i></label>
        <input type="text" name="cvv" placeholder="CVV">
      </div>
      <div class="field">
        <label>Month</label>
        <select name="month" class="wojo fluid dropdown">
          <?php foreach ($months as $month): ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          <?php endforeach;?>
        </select>
      </div>
      <div class="field">
        <label>Year</label>
        <select name="year" class="wojo fluid dropdown">
          <?php foreach ($year_expire as $year):?>
          <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>
    <div class="content-center">
      <button class="wojo black button" data-action="doAnet" data-url="<?php echo SITEURL;?>/gateways/anet/ipn.php" name="dosubmit" type="button"><?php echo Lang::$word->SUBMITP;?></button>
    </div>
  </form>
</div>
<div id="msgholder"></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('body [data-content]').popup({
		trigger: 'hover',
	});
	$("select").dropdown();
});
// ]]>
</script>