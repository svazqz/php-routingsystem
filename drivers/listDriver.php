<?php

class listDriver
{
	static $lists = array(
		"destinos" => array("MTY - APTO", "MTY - APTO", "APTO - MTY"),
		"vehiculos" => array("Camioneta", "Automovil")
	);
	
	public static function getValue($list, $key)
	{
		return self::$lists[$list][$key];
	}
}
