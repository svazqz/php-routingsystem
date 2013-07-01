<?php

class configDriver
{
	static private $instance = null;
	static private $dbtype = "mysql";
	static private $database = array(
		"mysql" => array(
			"host" => "",
			"username" => "",
			"password" => "",
			"database" => ""
		)
	);
	
	static private $mail = array("method" => "mail", "data" => array());
	
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

	public static function getDBConfig()
	{
		$dbObj = new stdClass();
		$dbObj->type = self::$dbtype;

		foreach (self::$database[self::$dbtype] as $key => $value) {
			$dbObj->$key = $value;
		}
		
		return $dbObj;
	}
	
	public static function getAutoloaders()
	{
		return self::$autoloaders;
	}
	
	public static function getMailConfig()
	{
		return self::$mail;
	}
	
	public function __clone()
	{
		trigger_error('Clone no se permite.', E_USER_ERROR);
	}
	
}