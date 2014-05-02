<?php
namespace Driver;
class Base
{
	private function __construct()
	{
		//Constructor generico
	}

	public static function getInstance() 
	{
		if (!isset(self::$instance)) 
		{ 
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	} 
}