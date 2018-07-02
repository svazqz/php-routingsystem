<?php

namespace Core;

use Interfaces\IController as IController;

abstract class Controller implements IController {
	protected $view = null;

	public function __construct($components = array()) {
		switch(count($components)) {
			case 0:
				$this->main();
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
					call_user_func_array(array($this, "main"), $components);
				}
				break;
		}
	}

	public function getView() {
		if($this->view == null) {
			$viewClass = str_replace("Controller", "View", get_class($this));
			try {
				$this->view = new $viewClass();
			} catch(Exeption $e) {
	
			}
		}
		return $this->view;
	}

}
