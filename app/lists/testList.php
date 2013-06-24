<?php

class testList
{
	public static $values = null;

	public static function getValue($val)
	{
		if(!self::$values)
			self::$values = new listBase(array("mx" => "México"));

		return self::$values->getValue($val);
	}
}