<?php

class sessionDriver extends driverBase {        
    
    private static $instance;
    
    public function __construct() {
        $session = new sessionHandler();
        session_set_save_handler(array($session, 'open'),
                         array($session, 'close'),
                         array($session, 'read'),
                         array($session, 'write'),
                         array($session, 'destroy'),
                         array($session, 'gc'));
        session_start();
    }
    
    private static function sessionInstance() {
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
    
    public static function setSession($session, $value) {
        if(self::sessionStarted() != true) {
            $s = self::sessionInstance();
        }
        $_SESSION[$session] = $value;
        if(self::sessionExists($session) == false) {
            throw new Exception('Unable to Create Session');
        }
    }
    
    public static function getSession($session) {
        if(self::sessionStarted() != true) {
            $s = self::sessionInstance();
        }
        if(isset($_SESSION[$session])) {
            return $_SESSION[$session];
        } 
    }

    public static function start($user = null, $pass = null) {
        $s = self::sessionInstance();
        if(isset($_SESSION['loggedin']))
            if($_SESSION['loggedin'])
                return true;
        if(is_object($user)) {
            
        } elseif(is_array($user) ) {
            $u = User::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($user['password'])){
                $_SESSION['loggedin'] = true;
                return true;
            }
        } else {
            $u = User::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($pass)){
                $_SESSION['loggedin'] = true;
                return true;
            }
        }
        return false;
    }

    public static  function close() {
        $s = self::sessionInstance();
        session_destroy();
    }
        
}
