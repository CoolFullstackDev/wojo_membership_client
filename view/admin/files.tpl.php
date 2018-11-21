<?php
  /**
   * File Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2017
   * @version $Id: files.tpl.php, v1.00 2017-05-09 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_files')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<div class="row half-gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->META_T35;?></h3>
    <p class="wojo small text"><?php echo str_replace("[LIMIT]", '<span class="wojo bold positive text">' . ini_get('upload_max_filesize') . '</span>', Lang::$word->FM_INFO);?></p>
  </div>
  <div class="column shrink mobile-100 phone-100">
    <div class="wojo small secondary button uploader" id="drag-and-drop-zone">
      <label><i class="icon plus alt"></i> <?php echo Lang::$word->UPLOAD;?>
        <input type="file" multiple name="files[]">
      </label>
    </div>
  </div>
</div>
<div id="fileList" class="wojo small attached relaxed middle aligned celled list"></div>
<div id="result"> </div>
<div class="wojo divider"></div>
<div class="half-top-padding">
  <div class="wojo divided horizontal link list align-center">
    <div class="disabled item wojo bold text"> <?php echo Lang::$word->FILTER_O;?> </div>
    <a href="<?php echo Url::url(Router::$path);?>" class="item<?php echo Url::setActive("type", false);?>"> <?php echo Lang::$word->FM_ALL_F;?> </a> <a href="<?php echo Url::url(Router::$path, "?type=audio");?>" class="item<?php echo Url::setActive("type", "audio");?>"> <i class="icon musical note"></i> <?php echo Lang::$word->FM_AUD_F;?> </a> <a href="<?php echo Url::url(Router::$path, "?type=video");?>" class="item<?php echo Url::setActive("type", "video");?>"> <i class="icon movie"></i> <?php echo Lang::$word->FM_VID_F;?> </a> <a href="<?php echo Url::url(Router::$path, "?type=image");?>" class="item<?php echo Url::setActive("type", "image");?>"> <i class="icon photo"></i> <?php echo Lang::$word->FM_AMG_F;?> </a> <a href="<?php echo Url::url(Router::$path, "?type=document");?>" class="item<?php echo Url::setActive("type", "document");?>"> <i class="icon files"></i> <?php echo Lang::$word->FM_DOC_F;?> </a> <a href="<?php echo Url::url(Router::$path, "?type=archive");?>" class="item<?php echo Url::setActive("type", "archive");?>"> <i class="icon book"></i> <?php echo Lang::$word->FM_ARC_F;?> </a> </div>
</div>
<div class="half-top-padding">
  <div class="wojo divided horizontal link list align-center">
    <div class="disabled item wojo bold text"> <?php echo Lang::$word->SORTING_O;?> </div>
    <a href="<?php echo Url::url(Router::$path);?>" class="item<?php echo Url::setActive("order", false);?>"> <?php echo Lang::$word->RESET;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=name|DESC");?>" class="item<?php echo Url::setActive("order", "name");?>"> <?php echo Lang::$word->NAME;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=alias|DESC");?>" class="item<?php echo Url::setActive("order", "alias");?>"> <?php echo Lang::$word->FM_ALIAS;?> </a> <a href="<?php echo Url::url(Router::$path, "?order=filesize|DESC");?>" class="item<?php echo Url::setActive("order", "filesize");?>"> <?php echo Lang::$word->FM_FSIZE;?> </a>
    <div class="item"><a href="<?php echo Url::sortItems(Url::url(Router::$path), "order");?>" data-tooltip="ASC/DESC"><i class="icon triangle unfold more link"></i></a> </div>
  </div>
</div>
<div class="half-top-padding"><?php echo Validator::alphaBits(Url::url(Router::$path), "letter", "wojo small bold text horizontal link divided list align-center");?> </div>
<?php if(!$this->data):?>
<div class="content-center"><img src="<?php echo ADMINVIEW;?>/images/notfound.png" alt="">
  <p class="wojo small thick caps text"><?php echo Lang::$word->FM_NOFILES;?></p>
</div>
<?php else:?>
<div class="wojo big space divider"></div>
<div class="row gutters screen-block-5 tablet-block-4 mobile-block-2 phone-block-1  content-center" id="fileData">
  <?php foreach ($this->data as $row):?>
  <div class="column" id="item_<?php echo $row->id;?>">
    <div class="wDimmer blurring dimmable">
      <div class="wojo inverted dimmer">
        <div class="content">
          <div class="center"> <a class="wojo icon secondary tiny circular button addAction" data-set='{"option":[{"doAction": 1,"page":"renameFile", "renameFile": 1,"processItem":1, "id":<?php echo $row->id;?>}], "label":"<?php echo Lang::$word->ASSIGN;?>", "url":"/helper.php", "parent":"#alias_<?php echo $row->id;?>", "action":"replace","modalclass":"mini"}'><i class="icon pencil"></i></a> <a data-set='{"option":[{"delete": "deleteFile","title": "<?php echo Validator::sanitize($row->alias, "spchar");?>","id":<?php echo $row->id;?>}],"action":"delete","parent":"#item_<?php echo $row->id;?>"}' class="wojo icon negative tiny circular button action"><i class="icon close"></i></a>
            <div class="wojo small space divider"></div>
            <p class="wojo tiny bold text"><?php echo $row->name;?></p>
            <p class="wojo tiny text"><?php echo Date::doDate("long_date", $row->created);?></p>
          </div>
        </div>
      </div>
      <div class="wojo files" style="background-color:<?php echo Content::fileStyle($row->type);?>"> <span class="size"><?php echo File::getSize($row->filesize);?></span>
        <div class="content"><?php echo Content::fileIcon($row->type);?></div>
        <div id="alias_<?php echo $row->id;?>" class="footer truncate"><?php echo $row->alias;?><span class="meta"><?php echo($row->fileaccess > 0 ? '<i class="icon tiny circular positive inverted check"></i>' : '<i class="icon tiny circular negative inverted minus"></i>');?></span></div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>
<div class="wojo big space divider"></div>
<div class="row half-gutters-mobile half-gutters-phone align-middle">
  <div class="columns shrink mobile-100 phone-100">
    <div class="wojo small thick text"><?php echo Lang::$word->TOTAL.': '.$this->pager->items_total;?> / <?php echo Lang::$word->CURPAGE.': '.$this->pager->current_page.' '.Lang::$word->OF.' '.$this->pager->num_pages;?></div>
  </div>
  <div class="columns mobile-100 phone-100 content-right mobile-content-left"><?php echo $this->pager->display_pages('small');?></div>
</div>
<script src="<?php echo ADMINVIEW;?>/js/files.js"></script> 
<script type="text/javascript"> 
// <![CDATA[	
$(document).ready(function() {
    $("#result").Manager({
        url: "<?php echo ADMINVIEW;?>",
        lang: {
            delete: "<?php echo Lang::$word->DELETE;?>",
			insert: "<?php echo Lang::$word->INSERT;?>",
			download: "<?php echo Lang::$word->DOWNLOAD;?>",
			unzip: "<?php echo Lang::$word->FM_UNZIP;?>",
			size: "<?php echo Lang::$word->FM_FSIZE;?>",
			lastm: "<?php echo Lang::$word->FM_LASTM;?>",
			items: "<?php echo strtolower(Lang::$word->ITEMS);?>",
			done: "<?php echo Lang::$word->DONE;?>",
			home: "<?php echo Lang::$word->HOME;?>",
        }
    });
});
// ]]>
</script>