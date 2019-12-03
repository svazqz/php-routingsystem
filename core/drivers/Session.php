<?php

use Handlers;

class Session {

  private static $instance;

  public function __construct() {
    $session = new Handlers\Session();
    session_set_save_handler(array($session, 'open'),
    array($session, 'close'),
    array($session, 'read'),
    array($session, 'write'),
    array($session, 'destroy'),
    array($session, 'gc'));
    session_start();
  }

  public static function sessionInstance() {
    if( !self::$instance instanceof self ) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public static function sessionStarted() {
    if(session_id() == '') {
      return false;
    } else {
      return true;
    }
  }

  public static function sessionExists($session) {
    if(self::sessionStarted() == false) {
      $s = self::sessionInstance();
    }
    if(isset($_SESSION[$session])) {
      return true;
    } else {
      return false;
    }
  }

  public static function set($session, $value) {
    if(self::sessionStarted() != true) {
      $s = self::sessionInstance();
    }
    $_SESSION[$session] = $value;
    if(self::sessionExists($session) == false) {
      throw new Exception('Unable to Create Session');
    }
  }

  public static function get($session) {
    if(self::sessionStarted() != true) {
      $s = self::sessionInstance();
    }
    if(isset($_SESSION[$session])) {
      return $_SESSION[$session];
    }

    throw new Exception("Variable de session {$session} no existe.");
  }

  public static  function close() {
    $s = self::sessionInstance();
    session_destroy();
  }

}
