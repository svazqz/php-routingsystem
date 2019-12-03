<?php

namespace Core;

class TemplateEngine {
	public static function render($template = null, $data = null, $type = null) {
		//TO DO load files based on extension
		$dirs = array_filter(glob(getcwd().'/app/templates/*'), 'is_dir');
        $loader = new \Twig_Loader_Filesystem(getcwd().'/app/templates');
        foreach($dirs as $d) {
            $namespace = substr($d , (strrpos($d, "/")-strlen($d)+1));
            if($namespace != "cache") {
				$loader->addPath($d, $namespace);
			}
        }
		$twig = new \Twig_Environment($loader);
		header('Content-Type: '.$type.'; charset=utf-8');
		$twig->display($template, $data);
	}
}
