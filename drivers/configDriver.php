<?php

class configDriver
{
	static private $instance = null;
	
	static private $database = array(
		"host" => "MVPGolden.db.5245242.hostedresource.com",
		"username" => "MVPGolden",
		"password" => "MVPGold3n!",
		"database" => "MVPGolden"
	);
	
	static private $autoloaders = array(
			"drivers" => array("unload" => "bootstrapper.php,configDriver.php"),
			"base" => array("unload" => ""),
			"controllers" => array("unload" => ""),
			"models" => array("unload" => ""),
			"views" => array("unload" => "")
	);
	
	static private $mail = array("method" => "mail", 
									"data" => array());
	
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
		
		$dbObj->username = self::$database['username'];
		$dbObj->host = self::$database['host'];
		$dbObj->password = self::$database['password'];
		$dbObj->database = self::$database['database'];
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