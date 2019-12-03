<?php

class Input {
  public const __POST__ = 0;
  public const __GET__ = 1;
  public static function getVar($name = null, $default = null, $type = null) {
    if($type != null){
      ($type == self::__POST__) ? 
      ( (isset($_POST[$name])) ? $_POST[$name] : $default ) : 
      ( ($type == self::__GET__) ? ( isset($_GET[$name]) ? $_GET[$name] : $default ) : null );
    } else{
      return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }
  }
}