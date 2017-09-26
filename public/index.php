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
				'development' => "{$_cfg->type}://{$_cfg->user}:{$_cfg->password}@{$_cfg->host}/{$_cfg->database}?charset=utf8"
			)
	);
});

$URI = $_SERVER['REQUEST_URI'];
$URI = parse_url('http://phproutingsystem.com'.$URI);
$URI = str_replace("/index.php", "", $URI["path"]);
$URI = str_replace("index.php", "", $URI);
$URI = str_replace("/", " ", $URI);
$URI = trim($URI);

if(strlen($URI) > 0) {
	$components = explode(" ", $URI);
} else {
	$components = array();
}

switch(count($components)) {
	case 0:
		$_classController = "App\\Controllers\\".ucfirst(Core\Drivers\Config::getInstance()->defaultController());
		$controller = new $_classController(null);
		break;
	default:
		$_classController = "App\\Controllers\\".ucfirst($components[0]);
		if(class_exists($_classController)) {
			$components = array_slice($components, 1);
			$controller = new $_classController($components);
		} else {
			$_classController = "App\\Controllers\\".ucfirst(Core\Drivers\Config::getInstance()->defaultController());
			$controller = new $_classController($components);
		}
		break;
}
