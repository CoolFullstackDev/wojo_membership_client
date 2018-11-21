<?php
  /**
   * Cron
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: cron.php, v1.00 2016-02-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
  require_once("../init.php");
  
  Cron::Run(1);