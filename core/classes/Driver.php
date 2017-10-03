<?php
namespace Core;

abstract class Driver {
	public static $instance;


	public function __clone() {
		trigger_error('Clone no se permite.', E_USER_ERROR);
	}

	public static function init() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
}
