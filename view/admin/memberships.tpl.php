<?php
  /**
   * Membership Manager
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: memberships.tpl.php, v1.00 2016-07-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if(!Auth::hasPrivileges('manage_memberships')): print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<?php switch(Url::segment($this->segments)): case "edit": ?>
<!-- Start edit -->
<?php include("_memberships_edit.tpl.php");?>
<?php break;?>
<!-- Start new -->
<?php case "new": ?>
<?php include("_memberships_new.tpl.php");?>
<?php break;?>
<!-- Start history -->
<?php case "history": ?>
<?php include("_memberships_history.tpl.php");?>
<?php break;?>
<!-- Start default -->
<?php default: ?>
<?php include("_memberships_grid.tpl.php");?>
<?php break;?>
<?php endswitch;?>