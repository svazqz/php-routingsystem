<?php

	include 'drivers/bootstrapper.php';

	

	bootstrapper::initApp();

	

	$components = explode("/", substr($_SERVER['ORIG_PATH_INFO'], 1));

	

	if($components[0] == "") $components = null;

	switch(count($components))

	{

		case 0:

			//Index

			$default = new reservacionesController();

			$default->baseName = "reservaciones";

			$default->index();

			break;

		case 1:

			//Action index controller

			$controller = strtolower($components[0])."Controller";

			if (class_exists($controller)) {

			    $controller = new $controller();

				$controller->baseName = strtolower($components[0]);

				$controller->index();

			} else{

				echo "Controller {$controller} no existe";

			}

			break;

		case 2:

			$controller = strtolower($components[0])."Controller";

			if (class_exists($controller)) {

			    $controller = new $controller();

				$controller->baseName = strtolower($components[0]);

				if(method_exists($controller, $components[1])){

					$controller->$components[1]();

				} else{

					echo "No puede ejecutarse la accion {$components[1]}";

				}

				

			} else{

				echo "Controller {$controller} no existe";

			}

			//Action controller

			break;

		default:

			//Parameter for action

			$controller = strtolower($components[0])."Controller";

			if (class_exists($controller)) {

			    $controller = new $controller();

				$controller->baseName = strtolower($components[0]);

				if(method_exists($controller, $components[1])){

					$i = 2;

					$p = array();

					while($components[$i])

					{

						$p[] = $components[$i];

						$i++;

					}

					call_user_func_array(array($controller, $components[1]), $p);

					unset($p);

				} else{

					echo "No puede ejecutarse la accion {$components[1]}";

				}

				

			} else{

				echo "Controller {$controller} no existe";

			}

			break;

	}

	

	

?>

