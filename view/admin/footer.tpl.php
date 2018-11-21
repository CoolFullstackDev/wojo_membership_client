<?php
  /**
   * Footer
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: footer.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
   $core = App::Core();
?>
<!-- Footer -->
  </main>
</div>
  <footer> Copyright &copy;<?php echo date('Y') . ' '. $core->company;?> <i class="icon middle wojologo"></i> Powered by: MMP v <?php echo $core->wojov;?> </footer>
<?php Debug::displayInfo();?>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/editor/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo ADMINVIEW;?>/js/master.js"></script> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $.Master({
        weekstart: <?php echo($core->weekstart);?>,
		ampm: "<?php echo ($core->time_format) == "hh:mm" ? false : true;?>",
		url: "<?php echo ADMINVIEW;?>",
		surl: "<?php echo SITEURL;?>",
        lang: {
            button_text: "<?php echo Lang::$word->BROWSE;?>",
            empty_text: "<?php echo Lang::$word->NOFILE;?>",
            monthsFull: [ <?php echo Date::monthList(false);?> ],
            monthsShort: [ <?php echo Date::monthList(false, false);?> ],
            weeksFull: [ <?php echo Date::weekList(false); ?> ],
            weeksShort: [ <?php echo Date::weekList(false, false);?> ],
			weeksMed: [ <?php echo Date::weekList(false, false, true);?> ],
            today: "<?php echo Lang::$word->TODAY;?>",
			now: "<?php echo Lang::$word->NOW;?>",
            clear: "<?php echo Lang::$word->CLEAR;?>",
            delBtn: "<?php echo Lang::$word->DELETE_REC;?>",
			trsBtn: "<?php echo Lang::$word->MTOTRASH;?>",
			restBtn: "<?php echo Lang::$word->RFCOMPLETE;?>",
			canBtn: "<?php echo Lang::$word->CANCEL;?>",
            delMsg1: "<?php echo Lang::$word->DELCONFIRM1;?>",
            delMsg2: "<?php echo Lang::$word->DELCONFIRM2;?>",
			delMsg3: "<?php echo Lang::$word->TRASH;?>",
			delMsg5: "<?php echo Lang::$word->DELCONFIRM4;?>",
			delMsg6: "<?php echo Lang::$word->DELCONFIRM6;?>",
			delMsg7: "<?php echo Lang::$word->DELCONFIRM10;?>",
			delMsg8: "<?php echo Lang::$word->DELCONFIRM3;?>",
            working: "<?php echo Lang::$word->WORKING;?>"
        }
    });
});
// ]]>
</script>
</body>
</html>