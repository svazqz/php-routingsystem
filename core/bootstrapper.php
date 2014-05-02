<?php

define("PS", PATH_SEPARATOR);
define("DS", "/");
define("__POST__", 1);
define("__GET__", 2);

class bootstrapper {

    public static $instance = null;

    private static $Namespaces = array(
        "Controller" => "app/controllers",
        "View" => "app/views",
        "Base" => "../core/bases",
        "Driver" => "../core/drivers",
        "Handler" => "handlers",
    );

    public function __construct() {}
    
    public static function boot() {

        if (  !self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function init() {
        spl_autoload_register(array($this,'autoLoader'));
        $this->loadVendors();
    }

    public function autoLoader($className) {
        $path = '';
        
        if ($lastNsPos = strrpos($className, '\\')) {
            //Accessing core classes by Namespace under core folder
            $namespace = substr($className, 0, $lastNsPos);
            if(array_key_exists($namespace, self::$Namespaces)) {
                $path .= self::$Namespaces[$namespace].DS.substr($className, $lastNsPos + 1).'.php';
            }
        } else {
            //Accessing app classes by NameType
            $parts = preg_split('/(?=[A-Z])/', $className, -1, PREG_SPLIT_NO_EMPTY);
            $type = $parts[count($parts)-1];
            //Is driver ??
            $path = "..".DS."core".DS."drivers".DS.$parts[0].".php";
            if(!file_exists($path)) {
                $class = substr($className, 0, strrpos($className, $type));
                $path = "..".DS.self::$Namespaces[$type].DS.$class.".php";
            }
        }
        
        if(file_exists($path)) {
            require $path;
        } else {
            $this->vendorAutoLoader($className);
        }
    }

    public function vendorAutoLoader($className) {
        $vendorsPath = "..".DS."vendors".DS;
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DS, $namespace) . DS;
        }
        $fileName .= str_replace('_', DS, $className) . '.php';
        
        if(file_exists($vendorsPath.$fileName)) {
            require $vendorsPath.$fileName;
        } else {
            throw new RuntimeException("The file: ".$fileName." does not exist! ");
        }
    }

    private function loadVendors() {
        //ActiveRecord PHP
        require_once '..'.DS.'vendors'.DS.'ActiveRecord'.DS.'ActiveRecord.php';
        ActiveRecord\Config::initialize(function($cfg) {
            $cfg->set_model_directory('..'.DS.'app/models');
            $cdb = Config::getDBConfig();
            $cfg->set_connections( array(
                    'development' => "mysql://{$cdb->username}:{$cdb->password}@{$cdb->host}/{$cdb->database}"
                )
            );
        });
        $whoops = new Whoops\Run();
        $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
        $whoops->register(); 
    }
    

}

