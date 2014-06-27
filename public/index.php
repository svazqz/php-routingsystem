<?php
	ini_set('display_errors','On');
	include '../core/bootstrapper.php';
	$Bootstrapper = bootstrapper::boot();

	$Bootstrapper->init();

	$components = array();
	
	if(isset($_SERVER['ORIG_PATH_INFO'])) {
		$components = explode("/", substr($_SERVER['ORIG_PATH_INFO'], 1));
    } else {
        if(isset ($_SERVER['PATH_INFO'])) {
            $components = explode("/", substr($_SERVER['PATH_INFO'], 1));
        } else {
            if(isset($_SERVER['QUERY_STRING']) ) {
                $components = explode("/", $_SERVER['QUERY_STRING']);
            }
        }
    }
	
    if(isset($components[0])) {
        if(trim($components[0]) == "") {
                $controller = "main";
        } else {
            $controller = $components[0];
        }
    } else {
        $controller = "main";
    }
    $controller = ucfirst($controller)."Controller";
	if (class_exists($controller)) {
		$controller = new $controller();
		$controller->execute();
	} else {
		echo "Controller {$controller} no existe.";
	}


