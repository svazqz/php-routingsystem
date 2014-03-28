<?php

define("PS", PATH_SEPARATOR);
define("DS", "/");
define("__POST__", 1);
define("__GET__", 2);

class bootstrapper {

    public static $loader;
    private static $paths = array(
        "controller" => "app/controllers",
        "view" => "app/views",
        "base" => "core/classes",
        "driver" => "core/drivers",
        "handler" => "core/handlers",
    );

    public static function init() {
        if (self::$loader == NULL)
            self::$loader = new self();
        
        return self::$loader;
    }

    public function __construct() {
        spl_autoload_register(array($this,'load'));
        spl_autoload_register(array($this,'vendorALoader'));
        $this->loadVendors();
    }
    
    private function loadVendors() {
        //ActiveRecord PHP
        require_once '..'.DS.'vendors'.DS.'php-activerecord'.DS.'ActiveRecord.php';
        ActiveRecord\Config::initialize(function($cfg) {
            $cfg->set_model_directory('..'.DS.'app/models');
            $cdb = configDriver::getDBConfig();
            $cfg->set_connections( array(
                    'development' => "mysql://{$cdb->username}:{$cdb->password}@{$cdb->host}/{$cdb->database}"
                )
            );
        });
        $this->vendorALoader("Whoops\Run");
        $whoops = new Whoops\Run();
        $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
        // Set Whoops as the default error and exception handler used by PHP:
        $whoops->register(); 
    }

    public function vendorALoader($className){
        $vendors = "../vendors/";
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DS, $namespace) . DS;
        }
        $fileName .= str_replace('_', DS, $className) . '.php';
        
        if(file_exists($vendors.$fileName)) 
            require $vendors.$fileName;
    }
    
    public function load($class) {
        $path = "";
        if(array_key_exists($class, self::$paths)) {
            $path = $paths[$class];
        } else {
            $parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);
            $path = self::$paths[strtolower($parts[count($parts)-1])];
        }
        $path = "..".DS.$path.DS.$class.".php";
        if(file_exists($path)) {
            include($path);
            //spl_autoload($class, spl_autoload_extensions());
        } else {
            return false;
        }
        
    }

}

