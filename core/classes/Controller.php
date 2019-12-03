<?php

namespace Core;

use Interfaces;

abstract class Controller implements Interfaces\IController {
	protected $view = null;

	public function __construct($components = array()) {
		if(count($components) == 0) {
			$this->main();
		} else {
			$method = $components[0];
			$components = array_slice($components, 1);
			call_user_func_array(array($this, $method), $components);
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
