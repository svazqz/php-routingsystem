<?php

namespace Core\Drivers;

use Core\Interfaces as Core;

class Template implements Core\IDriver {

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
    }

	public function __clone() {
		trigger_error('Not allowed.', E_USER_ERROR);
	}

    public static function init() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function render($template = null, $data = array()) {
		if($template != null) {
            $type = "text";
            $ext = "";
            $exti = strpos($template, ".");
            if($exti !== false) {
                $ext = substr($template, ($exti+1), strlen($template));
                if($ext != "html") {
                    $type = "application";
                }
            }
            header('Content-Type: '.$type.'/'.$ext.'; charset=utf-8');

            $this->twig->display($template, $data);

		}
	}

}
