<?php
chdir("..");
$loader = require getcwd() . '/vendor/autoload.php';

Drivers\Config::init();

$Config = Drivers\Config::get();

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

ActiveRecord\Config::initialize(function($cfg) {
	$Config = Drivers\Config::get();
	$cfg->set_model_directory(getcwd().'/app/models');
	$type = $Config->var("db.type", "mysql");
	$host = $Config->var("db.host", "");
	$user = $Config->var("db.user", "");
	$pass = $Config->var("db.password", "");
	$name = $Config->var("db.name", "");
	$cfg->set_connections(
		array(
			'development' => "{$type}://{$user}:{$pass}@{$host}/{$name}?charset=utf8"
		)
	);
});

$URI = $_SERVER['REQUEST_URI'];
$URI = parse_url('http://phproutingsystem.com'.$URI);
$URI = str_replace("/index.php", "", $URI["path"]);
$URI = str_replace("index.php", "", $URI);
$URI = str_replace("/", " ", $URI);
$URI = trim($URI);

$components = (strlen($URI) > 0) ? explode(" ", $URI) : array();
$main_controller = $Config->var("defaults.controller", "");
switch(count($components)) {
	case 0:
		$_classController = "Controllers\\".ucfirst($main_controller);
		$controller = new $_classController(null);
		break;
	default:
		$_classController = "Controllers\\".ucfirst($components[0]);
		if(class_exists($_classController)) {
			$components = array_slice($components, 1);
			$controller = new $_classController($components);
		} else {
			$_classController = "Controllers\\".ucfirst($main_controller);
			$controller = new $_classController($components);
		}
		break;
}
