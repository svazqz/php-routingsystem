<?php

class userView
{
	public function dispatchUserXML($user = null)
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
		if($user)
		{
			echo "<login valueId='{$user->id}'  />";
		}
		else 
		{
			echo " <error value='Usuario vacio.' /> ";
		}
		echo "</Message>";
	}
	
	public function dispatchErrorXML($error = null)
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message> <error value='{$error}' /> </Message>";
	}
	
}
