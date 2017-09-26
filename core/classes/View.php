<?php

namespace Core\Classes;

use Core\Drivers as Drivers;

abstract class View {
	protected $templateEngine;

	public function __construct() {
		$this->templateEngine = Drivers\Template::init();

	}

	public function displayContent($method, $data = null) {
		$this->show($method, $data);
	}

	public function displayContentArray($method, $data = null) {
		$this->showDataArray($method, $data);
	}

	public function show($method, $data = null) {
		if($data == null) {
			$this->$method();
		} else {
			call_user_func_array(array($this, $method), $data);
		}

	}
	public function showDataArray($method, $data = null) {
		$this->$method($data);
	}

	protected function render($viewLayout, $dataLayout = array(), $viewFormat = "html") {
		$this->templateEngine->render(strtolower((new \ReflectionClass($this))->getShortName())."/".$viewLayout.".".$viewFormat, $dataLayout);
	}

	protected function renderExternal($externalSpace, $viewLayout, $dataLayout = array(), $viewFormat = "html") {
		$this->templateEngine->render(strtolower($externalSpace)."/".$viewLayout.".".$viewFormat, $dataLayout);
	}

}
