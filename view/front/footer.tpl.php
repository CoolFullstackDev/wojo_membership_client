<?php
  /**
   * Footer
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: footer.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<!-- Footer -->
</div>
  <footer> Copyright &copy;<?php echo date('Y') . ' '. App::Core()->company;?></footer>
<script type="text/javascript" src="<?php echo FRONTVIEW;?>/js/master.js"></script> 
<?php Debug::displayInfo();?>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $.Master({
		url: "<?php echo FRONTVIEW;?>",
		surl: "<?php echo SITEURL;?>",
        lang: {
            button_text: "<?php echo Lang::$word->BROWSE;?>",
            empty_text: "<?php echo Lang::$word->NOFILE;?>",
        }
    });
});
// ]]>
</script>
</body>
</html>

