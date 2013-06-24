<?php

class testController extends controllerBase
{
	
	public function index()
	{
		echo "working!!!";
	}

	public function getVar($v)
	{
		echo $v;
	}
}