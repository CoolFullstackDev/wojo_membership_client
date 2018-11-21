<?php
  /**
   * Load Language Section
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: loadLanguageSection.tpl.php, v1.00 2016-01-08 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<?php
  $i = 0;
  $html = '';

  switch ($_GET['type']):
      case "filter":
          foreach ($this->section as $pkey):
              $i++;
              $html .= '
		  <div class="item">
			<div class="content"><span data-editable="true" data-set=\'{"type": "phrase", "id": ' . $i . ',"key":"' . $pkey['data'] .
                  '", "path":"lang"}\'>' . $pkey . '</span></div>
			<div class="content shrink"><span class="wojo mini basic disabled label">' . $pkey['data'] . '</span></div>
		  </div>';
          endforeach;
          break;

      default:
          foreach ($this->xmlel as $pkey):
              $i++;
              $html .= '
		  <div class="item">
			<div class="content"><span data-editable="true" data-set=\'{"type": "phrase", "id": ' . $i . ',"key":"' . $pkey['data'] .
                  '", "path":"lang"}\'>' . $pkey . '</span></div>
			<div class="content shrink"><span class="wojo mini basic disabled label">' . $pkey['data'] . '</span></div>
		  </div>';
          endforeach;
          break;

  endswitch;
  echo $html;