<?php

class inputDriver extends driverBase {
	public static function getVar($name = null, $default = null, $type = null) {
		if($type != null){

		} else{
			return $_REQUEST[$name] ? $_REQUEST[$name] : $default;
		}
	}
}