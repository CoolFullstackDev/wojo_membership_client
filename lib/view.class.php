<?php

  /**
   * View Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: view.class.php, v1.00 2016-10-20 18:20:24 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');


  class View
  {
      public $properties;
      public $path;
      public $template;
	  public $dir = null;
	  public $crumbs;


      /**
       * View::__construct()
       * 
       * @param mixed $path
       * @return
       */
      public function __construct($path)
      {
          $this->properties = array();
          $this->path = $path;
      }


      /**
       * View::render()
       * 
       * @param string $filename
       * @return
       */
      public function render()
      {

          try {
              if (!file_exists($this->path . $this->template)) {
                  Debug::AddMessage("errors", '<i>Exception</i>', 'filename ' . $this->path . $this->template . ' not found', "session");
                  throw new Exception($this->template . " template was not found");
              }
              Debug::addMessage('params', 'template', $this->template);
              ob_start();
			  if($this->dir) {
				  include_once ($this->path . $this->dir . 'header.tpl.php');
			  }
              include_once ($this->path . $this->template);
			  if($this->dir) {
				  include_once ($this->path . $this->dir . 'footer.tpl.php');
			  }
          }
          catch (exception $e) {
              echo 'Caught exception: ', Message::msgSingleError($e->getMessage());
          }

          return ob_get_clean();
      }

      /**
       * View::__set()
       * 
       * @param mixed $k
       * @param mixed $v
       * @return
       */
      public function __set($k, $v)
      {
          $this->properties[$k] = $v;
      }

      /**
       * View::__get()
       * 
       * @param mixed $k
       * @return
       */
      public function __get($k)
      {
          return $this->properties[$k];
      }
  }