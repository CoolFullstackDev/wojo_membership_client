<?php
  /**
   * Backup Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: backup.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_backup')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<div class="row gutters align-middle">
  <div class="column mobile-100 phone-100">
    <h3><?php echo Lang::$word->DBM_TITLE;?></h3>
    <p class="wojo small text"><?php echo Lang::$word->DBM_INFO;?></p>
  </div>
  <div class="column shrink mobile-100 phone-100"> <a data-set='{"option":[{"simpleAction": "1","action":"databaseBackup", "id":1}], "url":"/helper.php", "after":"prepend", "parent":"#backupList"}' class="wojo small secondary button simpleAction"><i class="icon plus alt"></i><?php echo Lang::$word->DBM_ADD;?></a> </div>
</div>
<div class="wojo segment">
  <div class="wojo relaxed divided flex list align-middle" id="backupList">
    <?php if ($this->data):?>
    <?php foreach ($this->data as $i => $row):?>
    <?php $i++;?>
    <?php $latest =  ($row == App::Core()->backup) ? " highlite" : null;?>
    <div class="item<?php echo $latest;?>">
      <div class="content"> <span class="wojo tiny bold text half-right-padding"><?php echo $i;?>.</span> <?php echo str_replace(".sql", "", $row);?></div>
      <div class="content shrink"><span class="wojo small basic label"><?php echo File::getFileSize($this->dbdir . '/' . $row, "kb", true);?></span> <a href="<?php echo UPLOADURL . '/backups/' . $row;?>" data-content="<?php echo Lang::$word->DOWNLOAD;?>" class="wojo icon circular basic positive small button"><i class="positive cloud download icon link"></i></a> <a data-set='{"option":[{"restore": "restoreBackup","title": "<?php echo $row;?>","id":1}],"action":"restore","parent":".item"}' data-content="<?php echo Lang::$word->RESTORE;?>" class="wojo icon circular basic small primary button action"> <i class="primary refresh icon link"></i></a> <a data-set='{"option":[{"delete": "deleteBackup","title": "<?php echo $row;?>","id":1}],"action":"delete","parent":".item"}' class="wojo icon circular basic small negative button action"> <i class="icon negative trash"></i> </a> </div>
    </div>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php endif;?>
  </div>
</div>