<?php

class inputDriver extends driverBase {
    public static function getVar($name = null, $default = null, $type = null) {
        switch ($name) {
            case __POST__ :
                return $_POST;
            case __GET__ :
                return $_GET;
            default :
                if($type != null){
                    ($type == __POST__) ? 
                    ( (isset($_POST[$name])) ? $_POST[$name] : $default ) : 
                    ( ($type == __GET__) ? ( isset($_POST[$name]) ? $_POST[$name] : $default ) : null );
                } else{
                    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
                }
                break;
        }
        
    }
}