<?php



class listBase

{

	var $values;

 	public function __construct($v = null){
 		$this->values = $v;
 	}

	public function getValue($key)
	{
		return $this->values[$key];
	}

}

