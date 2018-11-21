<?php
  /**
   * Load File
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: loadFile.tpl.php, v1.00 2016-03-02 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!$this->row) : Message::invalid("ID" . Filter::$id); return; endif;
?>
  <div class="column" id="item_<?php echo $this->row->id;?>">
    <div class="wDimmer blurring dimmable">
      <div class="wojo inverted dimmer">
        <div class="content">
          <div class="center"> <a class="wojo icon secondary tiny circular button addAction" data-set='{"option":[{"doAction": 1,"page":"renameFile", "renameFile": 1,"processItem":1, "id":<?php echo $this->row->id;?>}], "label":"<?php echo Lang::$word->ASSIGN;?>", "url":"/helper.php", "parent":"#alias_<?php echo $this->row->id;?>", "action":"replace","modalclass":"mini"}'><i class="icon pencil"></i></a> <a data-set='{"option":[{"delete": "deleteFile","title": "<?php echo Validator::sanitize($this->row->alias, "spchar");?>","id":<?php echo $this->row->id;?>, "filename":"<?php echo $this->row->name;?>"}],"action":"delete","parent":"#item_<?php echo $this->row->id;?>"}' class="wojo icon negative tiny circular button action"><i class="icon close"></i></a>
            <div class="wojo small space divider"></div>
            <p class="wojo tiny bold text"><?php echo $this->row->name;?></p>
            <p class="wojo tiny text"><?php echo Date::doDate("long_date", $this->row->created);?></p>
          </div>
        </div>
      </div>
      <div class="wojo files" style="background-color:<?php echo Content::fileStyle($this->row->extension);?>"> <span class="size"><?php echo File::getSize($this->row->filesize);?></span>
        <div class="content"><?php echo Content::fileIcon($this->row->extension);?></div>
        <div id="alias_<?php echo $this->row->id;?>" class="footer truncate"><?php echo $this->row->alias;?><span class="meta"><i class="icon tiny circular negative inverted minus"></i></span></div>
      </div>
    </div>
  </div>