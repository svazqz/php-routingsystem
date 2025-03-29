<?php

namespace Core;

use Interfaces;

abstract class Controller implements Interfaces\IController {
    protected $view = null;
    protected $__ROUTES__;

    private function matchRoute($uri) {
      if (!$this->__ROUTES__ ) return false;
      foreach ($this->__ROUTES__ as $pattern => $method) {
        $pattern = preg_quote($pattern, '/');
        $pattern = str_replace('\:id', '(\d+)', $pattern);
        if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
          array_shift($matches);
          return array($method, $matches);
        }
      }
      return false;
    }   

    public function __run($runnableData) {
      $components = $runnableData->components;
      $originalURI = $runnableData->originalURI;
    
      $matchingRoute = $this->matchRoute($originalURI);
      if ($matchingRoute) {
        list($method, $params) = $matchingRoute;
        call_user_func_array(array($this, $method), $params);
      }

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
        } catch(\Exception $e) {
        }
      }
      return $this->view;
    }

}
