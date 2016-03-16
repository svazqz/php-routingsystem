<?php

namespace Core;

class View {

	function __construct() {
		header('Content-Type: text/html; charset=utf-8');
		//header('Content-Type: application/xml; charset=utf-8');
		//header('Content-Type: application/json; charset=utf-8');
	}
}
