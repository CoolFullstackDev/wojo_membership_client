<?php
  /**
   * Payment Validate
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: validate.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<?php if(Validator::get('order_id')):?>
<div class="wojo segment"><h4><?php echo Lang::$word->STR_POK1;?> <i class="icon spinning spinner circles"></i></h4></div>
<?php else:?>
<?php Url::redirect(SITEURL);?>
<?php endif;?>
<?php if(Validator::get('order_id')):?>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $.ajax({
        type: 'GET',
        url: "<?php echo SITEURL;?>/gateways/ideal/ipn.php",
        dataType: 'json',
        data: {
            "order_id": "<?php echo Validator::sanitize(Validator::get('order_id'), "db");?>"
        }
    }).done(function(json) {
        if (json.type === "success") {
			$('.wojo-grid').velocity("transition.whirlOut", {
				duration: 4000,
				complete: function() {
					window.location.href = '<?php echo Url::url("/dashboard");?>';
				}
			});
        }
		$.sticky(decodeURIComponent(json.message), {
			autoclose: 12000,
			type: json.type,
			title: json.title
		});
    });
});
// ]]>
</script>
<?php endif;?>
