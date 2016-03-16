<?php

namespace Core;

use App\View;

class Controller {

	var $baseName = null;
	var $components = null;
	public function __construct($method = null, $attrs = null) {
		try {
			if($method == null) {
				$this->index();
			} else {
				if(count($attrs) > 0) {
					call_user_func_array(array($this, $method), $attrs);
				} else {
					call_user_func(array($this, $method));
				}
			}
		} catch (Exeption $e) {
			
		}
	}

	public function getView() {
		$view = str_replace("Controller", "View", get_class($this));
		try {
			$view = new $view();
			return $view;
		} catch(Exeption $e) {
			
		}
	}

}

