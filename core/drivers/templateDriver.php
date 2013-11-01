<?php

class templateDriver extends driverBase{
	
	static $section = null;
	static $data = null;

	public static function setSection($sect = null, $data = null){
		self::$section = "app/templates";
		foreach (explode('.', $sect) as $value) {
			self::$section = self::$section . "/" . $value;
		}
		self::$section = self::$section.".template.php";
	}

	public static function setData($d) {
		self::$data = $d;
	}

	public static function getData() {
		return self::$data;
	}

	public static function section(){
		if(!self::$section)
			self::setSection(configDriver::defaultView());
		include(self::$section);
	}
}
