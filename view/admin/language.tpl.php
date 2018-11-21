<?php
  /**
   * Language Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: language.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_languages')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<h3><?php echo Lang::$word->META_T21;?></h3>
<p class="wojo small text"><?php echo Lang::$word->LG_SUB2;?></p>
<div class="wojo space divider"></div>
<div class="row half-gutters">
  <div class="column screen-30 tablet-50 mobile-100 phone-100 screen-offset-20">
    <div class="wojo small fluid icon input">
      <input id="filter" type="text" placeholder="<?php echo Lang::$word->SEARCH;?>">
      <i class="find icon"></i> </div>
  </div>
  <div class="column screen-30 tablet-50 mobile-100 phone-100">
    <div class="wojo small fluid selection dropdown" id="pgroup"><i class="icon dropdown"></i>
      <div class="default text"><?php echo Lang::$word->LG_RESET;?></div>
      <div class="menu">
        <div class="item" data-type="all" data-value="all"><?php echo Lang::$word->LG_SUB4;?></div>
        <?php foreach($this->sections as $rows):?>
        <div class="item" data-type="filter" data-value="<?php echo $rows;?>"><?php echo $rows;?></div>
        <?php endforeach;?>
        <?php unset($rows);?>
      </div>
      <input type="hidden" name="pgroup" value="all">
    </div>
  </div>
</div>
<div class="wojo segment">
  <?php $i = 0;?>
  <div class="wojo small divided flex list align-middle" id="editable">
    <?php foreach ($this->data as $pkey) :?>
    <?php $i++;?>
    <div class="item">
      <div class="content"><span data-editable="true" data-set='{"type": "phrase", "id": <?php echo $i;?>,"key":"<?php echo $pkey['data'];?>", "path":"lang"}'><?php echo $pkey;?></span></div>
      <div class="content shrink"><span class="wojo mini basic disabled label"><?php echo $pkey['data'];?></span></div>
    </div>
    <?php endforeach;?>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[	
$(document).ready(function() {
  $("#filter").on("keyup", function() {
	  var filter = $(this).val(),
		  count = 0;
	  $("span[data-editable=true]").each(function() {
		  if ($(this).text().search(new RegExp(filter, "i")) < 0) {
			  $(this).parents('.item').fadeOut();
		  } else {
			  $(this).parents('.item').fadeIn();
			  count++;
		  }
	  });
  });
  
  $('#pgroup').on('click', '.item', function() {
	  var sel = $(this).data('value');
	  var type = $(this).data('type');
	  $('#pgroup').addClass('loading');
	  $.get("<?php echo ADMINVIEW . "/helper.php";?>", {
		  doAction: 1,
		  page: "loadLanguageSection",
		  type: type,
		  section: sel
	  }, function(json) {
		  $("#editable").html(json.html).fadeIn("slow");
		  $('#editable').editableTableWidget();
		  $('#pgroup').removeClass('loading');
	  }, "json");
  });
});
// ]]>
</script> 
