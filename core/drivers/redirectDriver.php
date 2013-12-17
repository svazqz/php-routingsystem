<?php

class redirectDriver extends driverBase {
	public static function toController($controller) {
		$controller = strtolower($controller)."Controller";
		$controller = new $controller();
		$controller->execute();
		exit;
	}
}