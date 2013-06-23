<?php

class bootstrapper
{
	public static function initApp()
	{
		include("drivers/configDriver.php");
		
		self::autoLoader();
	}
	
	private static function autoLoader()
	{
		$a = configDriver::getAutoloaders();
		foreach ($a as $dir => $value) 
		{
			$excluded = explode(",", str_replace(" ", '', $value['unload']));
			foreach (glob("{$dir}/*.php") as $filename)
			{
				$data = explode("/", $filename);
				if(in_array( $data[1] , $excluded) ) continue;
			    include $filename;
			}
		}
	}
}
