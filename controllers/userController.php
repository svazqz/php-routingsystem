<?php

	class userController extends controllerBase{
		
		public function index()
		{
			echo "Ok";
		}
		
		public function dispatch($correo = null)
		{
			//$correo = base64_decode($correo);
			echo $this->basename;
			$user = dbDriver::execQueryObject("SELECT * FROM logins where correo = '{$correo}' limit 1");
			$view = $this->getView();
			if($user->password == md5($_REQUEST['password']))
			{
				$view->dispatchUserXML($user);
				//$view = $this->getView();
			}
			else 
			{
				$view->dispatchError("Error al procesar la solicitud.");
			}
		}
		
		public function insert()
		{
			if (isset($_REQUEST['correo']) and isset($_REQUEST['password'])){
			    $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : "NULL";
			    $edad = isset($_REQUEST['edad']) ? $_REQUEST['edad'] : "NULL";
			    $genero = isset($_REQUEST['genero']) ? $_REQUEST['genero'] : "NULL";
			    $telefono = isset($_REQUEST['telefono']) ? $_REQUEST['telefono'] : "NULL";
			    
				$r = dbDriver::execQuery("INSERT INTO logins 
				(correo,password,nombre,edad,genero,telefono) 
				VALUES('$correo','$password','$nombre','$edad','$genero',$telefono)");
				
				if($r)
				{
					echo "El registro fue creado correctamente, ya puedes comenzar a utilizar la app.";
				} 
				else 
				{
					echo "Hubo un error al insertar, intentar nuevamente";
				}
			    
			}else{
			    echo "No se han definido los campos correo y contraseña.";
			}
			
		}
	}
