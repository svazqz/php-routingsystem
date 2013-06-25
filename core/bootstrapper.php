<?php

define("PS", PATH_SEPARATOR);
define("DS", "/");

class bootstrapper

{

    public static $loader;
    private static $paths = array(
        "controller" => "app/controllers",
        "view" => "app/views",
        "base" => "core/classes",
        "driver" => "core/drivers"
    );

    public static function init()
    {
        if (self::$loader == NULL)
            self::$loader = new self();

        return self::$loader;
    }

    public function __construct()
    {
        spl_autoload_register(array($this,'load'));
    }

    public function load($class)
    {
        $path = "";
        if(array_key_exists($class, self::$paths))
        {
            $path = $paths[$class];
        }
        else
        {
            $parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);
            $path = self::$paths[strtolower($parts[count($parts)-1])];
        }
        $path = $path.DS.$class.".php";
        if(file_exists($path))
        {
            include($path);
            spl_autoload($class, spl_autoload_extensions());
        }
        else
        {
            return false;
        }
        
    }

}

