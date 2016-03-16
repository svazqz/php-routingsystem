<?php
chdir("..");
$loader = require getcwd() . '/vendor/autoload.php';

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

ActiveRecord\Config::initialize(function($cfg) {
	$_cfg = Core\Drivers\Config::getInstance()->getDBConfig();
	$cfg->set_model_directory(getcwd().'/app/models');
	$cfg->set_connections( array(
				'development' => "{$_cfg->type}://{$_cfg->user}:{$_cfg->password}@{$_cfg->host}/{$_cfg->database}"
			)
	);
});

//Twig_Autoloader::register();

$components = explode("/", $_SERVER['QUERY_STRING']);

$controller = (isset($components[0]) && $components[0] != '') ? $components[0] : Core\Drivers\Config::getInstance()->defaultController();
$method = isset($components[1]) ? $components[1] : null;
$attrs = array();


if(count($components) > 2) {
	$attrs =  array_slice ($components, 2);
}

$controller = ucfirst($controller);
$controller = "App\\Controllers\\".$controller;

try {
	$controller = new $controller($method, $attrs);
} catch (Exeption $e) {
	
}