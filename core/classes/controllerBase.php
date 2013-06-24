<?php



class controllerBase

{

	var $baseName = null;


	public function getView()

	{

		$view = $this->baseName."View";

		if (class_exists($view)) 

		{

			$view = new $view();

			return $view;

		} 

		else

		{

			echo "No existe la vista especificada.";

			exit;

		}

	}

	public static function saludo()
	{
		echo "hola";
	}

}

