<?php
	ini_set('display_errors','On');
	include '../core/bootstrapper.php';

	bootstrapper::init();

	$components = array();
	
	if(isset($_SERVER['ORIG_PATH_INFO']))
		$components = explode("/", substr($_SERVER['ORIG_PATH_INFO'], 1));
	else
		$components = explode("/", substr($_SERVER['PATH_INFO'], 1));
	

	if(trim($components[0]) == "") {
		$components[0] = "main";
	}
	$controller = strtolower($components[0])."Controller";

	if (class_exists($controller)) {
		$controller = new $controller();
		$controller->execute();
	} else {
		echo "Controller {$controller} no existe.";
	}



