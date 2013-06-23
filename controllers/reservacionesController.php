<?php

class reservacionesController extends controllerBase
{
	
	public function index()
	{
		//Todas
		$view = $this->getView();
		$view->index();
	}
	
	public function proccess($id = null)
	{
		$r = dbDriver::execQuery("UPDATE reservaciones SET estatus=1 WHERE id={$id}");
		header("Location: /request/MVPGolden/");
	}
	
	public function insert()
	{
		$required = array('type', "direccion", "fecha", "horaServi", "pasajeros", "vehiculo", "terminal", "aerolinea",
		"noVuelo", "horaSalida", "status", "idLogin");
		$view = $this->getView();
		foreach ($required as $value) {
			if(trim($_POST[$value]) == ""){
				$view->dispatchErrorXML("Alguno de los campos está en blanco");
			}
		}
		$type = $_POST['type'];
		$direccion = $_POST['direccion'];
		$fecha = $_POST['fecha'];
		$horaServi=$_POST['horaServi'];
		$pasajeros=$_POST['pasajeros'];
		$vehiculo=$_POST['vehiculo'];
		$terminal=$_POST['terminal'];
		$aerolinea=$_POST['aerolinea'];
		$noVuelo=$_POST['noVuelo'];
		$horaSalida=$_POST['horaSalida'];
		$status=$_POST['status'];
		$idLogin=$_POST['idLogin'];
		$horaSali = date('H:i');
		
		$r = dbDriver::execQuery("INSERT INTO 
		reservaciones(type, direccion, hora_sali, hora_servi,fecha, pasajeros, vehiculo,terminal, aerolinea, no_vuelo, hora_salida, estatus, login) 
		VALUES('{$type}','{$direccion}', '{$horaSali}', '{$horaServi}','{$fecha}', '{$pasajeros}','{$vehiculo}', '{$terminal}', '{$aerolinea}', '{$noVuelo}', '{$horaSalida}', '{$status}', '{$idLogin}')");
		
		if($r)
		{
			
			
			$para = "reservacionesapp@goldentransportaciones.com,rmireles@goldentransportaciones.com,ajp@expertsys.com.mx";
            $titulo = 'Nueva solicitud de servicio';
            $mensaje = "Se ha generado una nueva solicitud de servicio, ingresa a la siguiente dirección para poder confirmarlo.\r\n \r\n http://animactiva.mx/request/MVPGolden";
            $cabeceras = array(
				"From" => "reservacionesapp@goldentransportaciones.com",
				"Reply-To" => "reservacionesapp@goldentransportaciones.com",
				"BCC" => "sergio@animactiva.mx",
				"X-Mailer" => 'PHP/' . phpversion()
 			);
			if(mail::send($para, $titulo, $mensaje, $cabeceras))
				$view->dispatchMessageXML("En un momento recibirá un correo con la confirmación de su servicio.");
			else
				$view->dispatchErrorXML("Error al enviar correo electronico.");
		}
		else
		{
			$view->dispatchErrorXML("Error al procesar su solicitud intentelo más tarde.");
		}
	}
}
