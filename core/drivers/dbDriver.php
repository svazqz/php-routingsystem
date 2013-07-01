<?php


class dbDriver extends driverBase
{
	private $n = 0;
	private static $instance = null;
	private static $dbm = null;
	

	private static function start()
	{
		$cdb = configDriver::getDBConfig();
		try
		{
			switch ($cdb->type) {
				case 'odbc':
					self::$dbm = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq={$cdb->route};Uid={$cdb->uid}");
					break;
				case 'pgsql':
					self::$dbm = new PDO("pgsql:dbname={$cdb->database};host={$cdb->host}", $cdb->username, $cdb->password);
					break;
				case 'sqlite':
					self::$dbm = new PDO("sqlite:{$cdb->path}");
					break;
				case 'mysql':
					self::$dbm = new PDO("mysql:host={$cdb->host};dbname={$cdb->database}", $cdb->username, $cdb->password);
					break;

				default:
					die("Tipo de base de datos no permitido");
					break;
			}
			self::$dbm->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$dbm->setAttribute(PDO::ATTR_PERSISTENT, true); 
			self::$dbm->query('SET NAMES utf8');
		}
		catch(PDOException $e)
	    {
	    	echo $e->getMessage();
	    }
			
	}

	public static function close()
	{
		self::$dbm = null;
	}
	
	public function execQuery($query = null)
	{
		if(!self::$dbm) self::start();
		if(!$query) return;
		self::$dbm->beginTransaction();
		self::$dbm->exec($query);
		self::$dbm->commit();
	}
	
	public function execQueryObject($query = null, $lo = false)
	{
		if(!self::$connection) self::start();
		if(!$query) return;
		
		try
		{
			$rows = self::$dbm->query($query);
			$return = array();
			if($rows)
				foreach ($rows as $row)
	        	{
	        		$r = new stdClass();
					foreach ($row as $key => $value) {
						$r->$key = $value;
					}
					$return[] = $r;
	        	}
	        	if(count($return) == 1 && !$lo) $return = $return[0];
	        	return $return;
			
			return null;	
			
		} 

		catch (Exception $e){
			return mysql_error();
		}
		
	}

}

