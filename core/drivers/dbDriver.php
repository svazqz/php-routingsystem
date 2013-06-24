<?php


class dbDriver
{
	private $n = 0;
	private static $instance = null;
	private static $connection = null;

	private function __construct()
	{
		//Constructor generico
	}

	public static function getInstance()
	{
		if (  !self::$instance instanceof self)
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	private static function start()
	{
		$cdb = configDriver::getDBConfig();
		self::$connection = mysql_connect($cdb->host, $cdb->username, $cdb->password);
		mysql_select_db($cdb->database, self::$connection);
	}
	
	public function execQuery($query = null)
	{
		if(!self::$connection) self::start();
		if(!$query) return;
		return mysql_query($query, self::$connection);
	}
	
	public function execQueryObject($query = null, $lo = false)
	{
		if(!self::$connection) self::start();
		if(!$query) return;
		
		try
		{
			$request = mysql_query($query, self::$connection);
			if(mysql_num_rows($request) > 0)
			{
				$return = array();
				while($row = mysql_fetch_assoc($request))
				{
					$r = new stdClass();
					foreach ($row as $key => $value) {
						$r->$key = $value;
					}
					$return[] = $r;
				}
				if(count($return) == 1 && !$lo) $return = $return[0];
				return $return;
			}
				
			return null;
		} 

		catch (Exception $e){
			return mysql_error();
		}
		
	}

	public static function execQueryValue($query = null){

	}

}

