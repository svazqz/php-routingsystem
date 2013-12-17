<?php

class viewBase {

	function __construct() {
		header('Content-Type: text/html; charset=utf-8');
	}

	public static function raw($page = null, $data = null) {
		templateDriver::setData($data);
		include("..".DS."app".DS."templates".DS.".str_replace(".", '/', $page).".template.php");
	}

	public static function Template($template = null, $data = null) {
		templateDriver::setData($data);
		if($template)
			templateDriver::setContent($template);
		else
			templateDriver::setContent(configDriver::defaultView());
		include("..".DS."app".DS."templates".DS."index.template.php");
	}
	
}
