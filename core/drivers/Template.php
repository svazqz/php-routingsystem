<?php

namespace Core\Drivers;

class Template {
    
    private static $instance = null;
    
    private $loader = null;
    private $twig = null;
    
    private function __construct() {
        $dirs = array_filter(glob(getcwd().'/app/templates/*'), 'is_dir');
        $this->loader = new \Twig_Loader_Filesystem(getcwd().'/app/templates');
        foreach($dirs as $d) {
            $namespace = substr($d , (strrpos($d, "/")-strlen($d)+1));
            if($namespace != "cache") {
				$this->loader->addPath($d, $namespace);
			}
        }
        $this->twig = new \Twig_Environment($this->loader);
		/*, array(
            //'cache' => getcwd().'/app/templates/cache',
			'cache' => false
        ));*/
    }
	
	public function __clone() {
		trigger_error('Clone no se permite.', E_USER_ERROR);
	}
    
    public static function init() 
	{
		if (!isset(self::$instance)) 
		{ 
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	} 
    
	public function render($template = null, $data = array()) {
		if($template != null) {
			if(strpos($template, "/")) {
				$this->twig->display("@".$template.".html", $data);
			} else {
				$this->twig->display($template.".html", $data);
			}
		}
	}
    
}