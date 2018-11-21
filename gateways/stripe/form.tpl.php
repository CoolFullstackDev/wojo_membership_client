<?php
  /**
   * Stripe Form
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: form.tpl.php, v1.00 2016-03-20 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo small secondary segment form" id="stripe_form">
  <form method="post" id="stripe">
  <div class="wojo fields">
    <div class="field">
      <label><?php echo Lang::$word->STR_CCN;?></label>
      <input type="text" autocomplete="off" name="ccn" placeholder="<?php echo Lang::$word->STR_CCN;?>">
    </div>
    </div>
    <div class="wojo fields">
      <div class="field">
        <label><?php echo Lang::$word->STR_CCV;?></label>
        <input type="text" autocomplete="off" name="cvc" placeholder="<?php echo Lang::$word->STR_CCV;?>">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->STR_CEXM;?></label>
        <input type="text" autocomplete="off" name="ccm" placeholder="MM">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->STR_CEXY;?></label>
        <input type="text" autocomplete="off" name="ccy" placeholder="YYYY">
      </div>
    </div>
     <div class="content-center">
      <button class="wojo black button" id="dostripe" name="dostripe" type="button"><?php echo Lang::$word->SUBMITP;?></button>
    </div>
    <input type="hidden" name="processStripePayment" value="1" />
  </form>
</div>
<div id="smsgholder"></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
    $('#dostripe').on('click', function() {
        $("#stripe_form").addClass('loading');
        var str = $("#stripe").serialize();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: "<?php echo SITEURL;?>/gateways/stripe/ipn.php",
            data: str,
            success: function(json) {
                $("#stripe_form").removeClass('loading');
                if (json.type == "success") {
                    $('.wojo-grid').velocity("transition.whirlOut", {
                        duration: 4000,
                        complete: function() {
                            window.location.href = '<?php echo Url::url("/dashboard");?>';
                        }
                    });
                }
                if (json.message) {
                    $.sticky(decodeURIComponent(json.message), {
                        autoclose: 12000,
                        type: json.type,
                        title: json.title
                    });
                }
            }
        });
        return false;
    });
});
// ]]>
</script>