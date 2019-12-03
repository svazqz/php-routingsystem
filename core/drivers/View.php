<?php

class View {

  private static $instance = null;
  private $data = array();

  private function __construct() {
  }

  public function __clone() {
    trigger_error('Clone not allowed.', E_USER_ERROR);
  }

  public static function get() {
    if (self::$instance == null) {
      $c = __CLASS__;
      $instance = new $c();
      self::$instance = $instance;
    }
    return self::$instance;
  }

  private function render($template = null, $_data = null, $type = "text", $ext = "html") {
    //Check if $data is not null and its an array otherwise use the instance data
    Core\TemplateEngine::render($template.".".$ext, $_data, $type."/".$ext);
  }

  public static function renderHTML($template = null, $_data = null) {
    self::get()->render($template, $_data);
  }

  public static  function renderJSON($template = null, $_data = null) {
    self::get()->render($template, $_data);
  }

  public static  function renderXML($template = null, $_data = null) {
    self::get()->render($template, $_data);
  }
}
