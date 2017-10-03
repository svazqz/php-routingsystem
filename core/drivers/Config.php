<?php
namespace Drivers;

class Config {
	private static $instance = null;

	private $enviroment = "local";

	private $enviroments = array(
		"local" => array(
			"mainController" => "home",
			"db_host" => "127.0.0.1",
			"db_user" => "root",
			"db_password" => "root",
			"db_name" => "phproutingsystem"
		)
	);

	private function __construct($env) {
		if($env != null) {
			$this->enviroment = $env;
		}
	}

	public function __clone() {
		trigger_error('Clone no se permite.', E_USER_ERROR);
	}

	public static function get($env = null) {
		if (self::$instance == null || $env != null) {
			$c = __CLASS__;
			$instance = new $c($env);
			if($env != null) {
				return $instance;
			}
			self::$instance = $instance;
		}
		return self::$instance;
	}

	public function var($config_var = "", $default = null) {
		if(isset($this->enviroments[$this->enviroment][$config_var])) {
			return $this->enviroments[$this->enviroment][$config_var];
		}
		return $default;
	}
}
