<?php
  /**
   * User Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: _users_history.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<h3><?php echo Lang::$word->META_T5;?> <small>// <?php echo $this->data->fname;?> <?php echo $this->data->lname;?></small></h3>
<div class="wojo segment">
  <div id="legend" class="wojo small horizontal list align-right"></div>
  <div id="payment_chart" style="height:300px;"></div>
</div>
<div class="row">
  <div class="column">
    <ul class="wojo tabs">
      <li class="active"><a data-tab="#mem"><i class="icon membership"></i> <?php echo Lang::$word->ADM_MEMBS;?></a></li>
      <li><a data-tab="#pay"><i class="icon credit card"></i> <?php echo Lang::$word->TRX_PAY;?></a></li>
    </ul>
  </div>
  <div class="column shrink"><a href="<?php echo ADMINVIEW . '/helper.php?exportUserPayments&amp;id=' . $this->data->id;?>" class="wojo tiny secondary button"><?php echo Lang::$word->EXPORT;?></a></div>
</div>
<div class="wojo attached tabbed segment">
  <div id="mem" class="wojo tab item">
    <?php if($this->mlist):?>
    <table class="wojo basic table">
      <thead>
        <tr>
          <th><?php echo Lang::$word->NAME;?></th>
          <th><?php echo Lang::$word->MEM_ACT;?></th>
          <th><?php echo Lang::$word->MEM_EXP;?></th>
          <th class="collapsing"><?php echo Lang::$word->MEM_REC1;?></th>
        </tr>
      </thead>
      <?php foreach ($this->mlist as $mrow):?>
      <tr>
        <td><a class="inverted" href="<?php echo Url::url("/admin/memberships", $mrow->mid);?>"><?php echo $mrow->title;?></a></td>
        <td><?php echo Date::doDate("long_date", $mrow->activated);?></td>
        <td><?php echo Date::doDate("long_date", $mrow->expire);?></td>
        <td class="center aligned"><?php echo Utility::isPublished($mrow->recurring);?></td>
      </tr>
      <?php endforeach;?>
    </table>
    <?php endif;?>
  </div>
  <div id="pay" class="wojo tab item">
    <?php if($this->plist):?>
    <table class="wojo basic table">
      <thead>
        <tr>
          <th><?php echo Lang::$word->NAME;?></th>
          <th><?php echo Lang::$word->TRX_AMOUNT;?></th>
          <th><?php echo Lang::$word->TRX_TAX;?></th>
          <th><?php echo Lang::$word->TRX_COUPON;?></th>
          <th><?php echo Lang::$word->TRX_TOTAMT;?></th>
          <th><?php echo Lang::$word->CREATED;?></th>
          <th class="collapsing"><?php echo Lang::$word->STATUS;?></th>
        </tr>
      </thead>
      <?php foreach ($this->plist as $prow):?>
      <tr>
        <td><a class="inverted" href="<?php echo Url::url("/admin/memberships/edit", $prow->membership_id);?>"><?php echo $prow->title;?></a></td>
        <td><?php echo $prow->rate_amount;?></td>
        <td><?php echo $prow->tax;?></td>
        <td><?php echo $prow->coupon;?></td>
        <td><?php echo $prow->total;?></td>
        <td><?php echo Date::doDate("short_date", $prow->created);?></td>
        <td class="center aligned"><?php echo Utility::isPublished($prow->status);?></td>
      </tr>
      <?php endforeach;?>
    </table>
    <div class="wojo double divider"></div>
    <div class="wojo small primary button"><?php echo Lang::$word->TRX_TOTAMT;?> <?php echo Utility::formatMoney(Stats::doArraySum($this->plist, "total"));?></div>
    <?php endif;?>
  </div>
</div>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/morris.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/raphael.min.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function() {	
    function getStats(range) {
        $("#payment_chart").parent().addClass('loading');
        $.ajax({
            type: 'GET',
            url: "<?php echo ADMINVIEW . '/helper.php?getUserPaymentsChart=1&id=' . $this->data->id;?>&timerange=" + range,
            dataType: 'json'
        }).done(function(json) {
			var legend = '';
            json.legend.map(function(val) {
               legend += val;
            });
			$("#legend").html(legend);
            Morris.Line({
                element: 'payment_chart',
                data: json.data,
                xkey: 'm',
                ykeys: json.label,
                labels: json.label,
                parseTime: false,
                lineWidth: 4,
                pointSize: 6,
                lineColors: json.color,
                gridTextFamily: "mavenProRegular",
                gridTextColor: "rgba(0,0,0,0.6)",
				gridTextSize: 14,
                fillOpacity: '.75',
                hideHover: 'auto',
				preUnits: json.preUnits,
				hoverCallback: function(index, json, content) {
					var text = $(content)[1].textContent;
					return content.replace(text, text.replace(json.preUnits, ""));
				},
                smooth: true,
                resize: true,
            });
            $("#payment_chart").parent().removeClass('loading');
        });
    }
    getStats('all');
});
// ]]>
</script>