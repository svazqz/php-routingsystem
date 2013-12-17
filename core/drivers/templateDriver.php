<?php

class templateDriver extends driverBase{
	
	static $content = null;
	static $data = null;

	public static function displaySection($sect = null, $data = null){
		$section = "..".DS."app".DS."templates";

		foreach (explode('.', $sect) as $value) {
			$section = $section . DS . $value;
		}
		$section = $section.".template.php";
		include($section);
	}

	public static function content() {
		self::displaySection(self::$content);
	}

	public static function setContent($content) {
		self::$content = $content;
	}

	public static function setData($d) {
		self::$data = $d;
	}

	public static function getData() {
		return self::$data;
	}
}
