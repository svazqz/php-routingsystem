<?php



class controllerBase

{

	var $baseName = null;
	var $components = null;
	public function __construct()
	{
		if(isset($_SERVER['ORIG_PATH_INFO']))
			$this->components = substr($_SERVER['ORIG_PATH_INFO'], 1);
		else
			$this->components = substr($_SERVER['PATH_INFO'], 1);
		
		if( strrpos($this->components, "/") == ( strlen($this->components)-1 ) )
			$this->components = substr_replace($this->components, '', (strlen($this->components)-2));
		
		$this->components = explode("/", $this->components);
		
		$this->baseName = strtolower($this->components[0]);

	}

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

			echo "No existe la vista especificada. {$this->baseName}";

			exit;

		}

	}

	public function execute()
	{
		if(isset($this->components[1]))
		{
			if(method_exists($this, $this->components[1])){

				if(isset($this->components[2]))
				{
					$i = 2;

					$p = array();
					
					while(isset($this->components[$i]))
					{
						
						$p[] = $this->components[$i];

						$i++;

					}
					try
					{
						call_user_func_array(array($this, $this->components[1]), $p);
					}
					catch (Exception $e)
					{
						die($e);
					}
					
				}
				else
				{
					$method = $this->components[1];
					$this->$method();
				}

			} else{

				echo "No puede ejecutarse la accion {$this->components[1]}";

			}
		}
		else
		{
			if(method_exists($this, "index"))
				$this->index();
			else
				die("Fatal!");
		}
	}

}

