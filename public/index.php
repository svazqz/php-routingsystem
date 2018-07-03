<?php
chdir("..");
require getcwd() . '/vendor/autoload.php';

Config::init();

$Config = Config::get();

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

ActiveRecord\Config::initialize(function($cfg) {
	$Config = Config::get();
	$cfg->set_model_directory(getcwd().'/app/models');
	$type = $Config->getVar("db.type", "mysql");
	$host = $Config->getVar("db.host", "");
	$user = $Config->getVar("db.user", "");
	$pass = $Config->getVar("db.password", "");
	$name = $Config->getVar("db.name", "");
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
$namespace = "Controllers\\";
$controller = $Config->getVar("defaults.controller", "");
if(count($components) > 0) {
	$controller = $components[0];
	if($controller == "api") {
		$namespace .= "API\\";
		$controller = $components[1];
		$components = array_slice($components, 2);
	} else {
		$components = array_slice($components, 1);
	}
	
}
$_classController = $namespace.ucfirst($controller);
$_controller = new $_classController($components);