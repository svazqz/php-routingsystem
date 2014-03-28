<?php

class authDriver extends driverBase {
    
    public static function login($user = null, $pass = null) {
        $s = sessionDriver::sessionInstance();
        if(isset($_SESSION['loggedin']))
            if($_SESSION['loggedin'])
                return true;
        if(is_object($user)) {
            
        } elseif(is_array($user) ) {
            $u = User::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($user['password'])){
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $u->id;
                return true;
            }
        } else {
            $u = User::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($pass)){
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $u->id;
                return true;
            }
        }
        return false;
    }
    
    public static function logins($user = null, $pass = null) {
        $s = sessionDriver::sessionInstance();
        if(isset($_SESSION['loggedin']))
            if($_SESSION['loggedin'])
                return true;
        if(is_object($user)) {
            
        } elseif(is_array($user) ) {
            $u = Systemuser::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($user['password'])){
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $u->id;
                return true;
            }
        } else {
            $u = Systemuser::find_by_username($user['username']);
            if(!$u) return false;
            if($u->password == md5($pass)){
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $u->id;
                return true;
            }
        }
        return false;
    }
    
    public static function getUser() {
        if( sessionDriver::sessionExists('loggedin') ) {
            $u = User::find(sessionDriver::getSession('user_id'));
            return $u;
        }
        return false;
    }
    
    public static function getSUser() {
        if( sessionDriver::sessionExists('loggedin') ) {
            $u = Systemuser::find(sessionDriver::getSession('user_id'));
            return $u;
        }
        return false;
    }
    
    public static function logout() {
        sessionDriver::close();
    }
    
    public static function isLoggedin() {
        if( sessionDriver::sessionExists('loggedin') ) {
            return true;
        }
        return false;
    }
    
    public static function chkLoggin() {
        return true;
        if( !authDriver::isLoggedin() )
            responseDriver::dispatch('E', 'No se ha iniciado sesión', 'No se ha iniciado sesión en el sistema');
    }
}