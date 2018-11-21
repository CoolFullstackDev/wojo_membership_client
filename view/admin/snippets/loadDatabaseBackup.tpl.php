<?php
  /**
   * Load Database Backup
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: loadDatabaseBackup.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<div class="item">
  <div class="content"> <span class="wojo tiny bold text half-right-padding">-1.</span> <?php echo str_replace(".sql", "", $this->backup);?></div>
  <div class="content shrink"><span class="wojo small basic label"><?php echo File::getFileSize($this->dbdir . '/' . $this->backup, "kb", true);?></span> 
  <a href="<?php echo UPLOADURL . '/backups/' . $this->backup;?>" data-content="<?php echo Lang::$word->DOWNLOAD;?>" class="wojo icon circular basic positive small button"><i class="positive cloud download icon link"></i></a> 
  <a data-set='{"option":[{"restore": "restoreBackup","title": "<?php echo $this->backup;?>","id":1}],"action":"restore","parent":".item"}' class="wojo icon circular basic small primary button action"> <i class="primary refresh icon link"></i></a> 
  <a data-set='{"option":[{"delete": "deleteBackup","title": "<?php echo $this->backup;?>","id":1}],"action":"delete","parent":".item"}' class="wojo icon circular basic small negative button action"> <i class="icon negative trash"></i> </a> </div>
</div>