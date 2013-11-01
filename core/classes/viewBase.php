<?php

class viewBase {

	function __construct() {
		header('Content-Type: text/html; charset=utf-8');
	}

	public static function Template($template = null, $data = null) {
		templateDriver::setData($data);
		if($template)
			templateDriver::setSection($template);
		include("app/templates/index.template.php");
	}
	
}
