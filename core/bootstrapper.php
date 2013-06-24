<?php

define("PS", PATH_SEPARATOR);
define("DS", "/");

class bootstrapper

{

	public static $loader;

    public static function init()
    {
    	

		$paths = array(
			"core" => array("classes" => "base", "drivers" => "driver"),
			"app" => array("controllers" => "c", "views" => "v", "models" => "m", "lists" => "l")
		);
		
		foreach ($paths as $main => $folders) {
			foreach ($folders as $folder => $extensions) {
				set_include_path(get_include_path().PS.$main.DS.$folder.DS);
			}
			
		}
		spl_autoload_extensions('.php');
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
        spl_autoload($class);
    }

}

