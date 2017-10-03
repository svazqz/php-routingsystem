<?php

namespace Core;

use Interfaces\IController as IController;

abstract class Controller implements IController {

	public function __construct($components) {
		switch(count($components)) {
			case 0:
				$this->index();
				break;
			default:
				$method = $components[0];
				if(method_exists($this, $method)) {
					$components = array_slice($components, 1);
					if(count($components) > 0) {
						call_user_func_array(array($this, $method), $components);
					} else {
						$this->$method();
					}
				} else {
					$this->index($components);
				}
				break;
		}
	}

	public function getView($viewClass = null) {
		if($viewClass == null) {
			$viewClass = str_replace("Controller", "View", get_class($this));
		} else {
			$viewClass = 'App\\Views\\'.ucfirst(strtolower($viewClass));
		}

		try {
			$view = new $viewClass();
			return $view;
		} catch(Exeption $e) {

		}
	}

}
