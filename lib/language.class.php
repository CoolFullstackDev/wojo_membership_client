<?php

  /**
   * Language
   * 
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2014
   * @version $Id: lang.class.php, v 1.00 2014-01-10 21:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');


  final class Lang
  {
      const langdir = "lang/";
      public static $language;
      public static $word = array();
      public static $lang;


      /**
       * Lang::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          self::get();
      }

      /**
       * Lang::Index()
       * 
       * @return
       */
      public function Index()
      {
		  $tpl = App::View(BASEPATH . 'view/');
		  $tpl->dir = "admin/";
		  $tpl->title = Lang::$word->META_T21;
		  $tpl->data = simplexml_load_file(BASEPATH . self::langdir . Core::$language . ".lang.xml");
		  $tpl->sections = self::getSections();
		  $tpl->template = 'admin/language.tpl.php';
      }
	  
      /**
       * Lang::get()
       * 
       * @return
       */
      private static function get()
      {
		  $core = App::Core();
          if (isset($_COOKIE['LANG_MMP'])) {
              $sel_lang = sanitize($_COOKIE['LANG_MMP'], 2);
              $vlang = self::fetchLanguage($sel_lang);
              if (in_array($sel_lang, $vlang)) {
                  Core::$language = $sel_lang;
              } else {
                  Core::$language = $core->lang;
              }
              if (file_exists(BASEPATH . self::langdir . Core::$language . ".lang.xml")) {
                  self::$word = self::set(BASEPATH . self::langdir . Core::$language . ".lang.xml", Core::$language);
              } else {
                  self::$word = self::set(BASEPATH . self::langdir . $core->lang . ".lang.xml", $core->lang);
              }
          } else {
              Core::$language = $core->lang;
              self::$word = self::set(BASEPATH . self::langdir . $core->lang . ".lang.xml", $core->lang);

          }
          self::$lang = "_" . Core::$language;
          return self::$word;
      }

      /**
       * Lang::set()
       * 
       * @return
       */
      private static function set($lang)
      {
          $xmlel = simplexml_load_file($lang);
          $data = new stdClass();
          foreach ($xmlel as $pkey) {
              $key = (string)$pkey['data'];
              $data->$key = (string)str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
          }

          return $data;
      }

      /**
       * Lang::getSections()
       * 
       * @return
       */
      public static function getSections()
      {
          $xmlel = simplexml_load_file(BASEPATH . self::langdir . Core::$language . ".lang.xml");
          $query = '/language/phrase[not(@section = preceding-sibling::phrase/@section)]/@section';
		  
		  $sections = [];

          foreach ($xmlel->xpath($query) as $text) {
              $sections[] = (string )$text;
          }
          asort($sections);
          return $sections;
      }

      /**
       * Lang::fetchLanguage()
       * 
       * @return
       */
      public static function fetchLanguage()
      {
          $directory = BASEPATH . self::langdir;
          return File::findFiles($directory, array('fileTypes' => array('xml'), 'returnType' => 'fileOnly'));
      }

      /**
       * Lang:::langIcon()
       * 
       * @return
       */
      public static function langIcon()
      {
          return "<div class=\"wojo primary tiny button\">" . strtoupper(Core::$language) . "</div>";
      }
  }