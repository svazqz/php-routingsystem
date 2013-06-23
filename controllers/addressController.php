<?php

class addressController extends controllerBase
{
	public function index()
	{
		
	}
	
	public function dispatch($id = null)
	{
		if(!$id) return;
		$view = $this->getView();
		$direcciones = dbDriver::execQueryObject("SELECT * FROM direcciones where login = '{$id}' ORDER BY id DESC");
		$view->dispatchXML($direcciones);
	}
	
	public function insert()
	{
		$required = array('alias', 'calle', 'numero', 'colonia', 'cp', 'municipio', 'calle1', 'calle2', 'idLogin');
		$view = $this->getView();
		foreach ($required as $value) {
			if(trim($_POST[$value]) == ""){
				$view->dispatchErrorXML("Alguno de los campos está en blanco");
			}
		}
		
		$alias = $_POST['alias'];
		$calle=$_POST['calle'];
		$numero=$_POST['numero'];
		$colonia=$_POST['colonia'];
		$cp=$_POST['cp'];
		$municipio=$_POST['municipio'];
		$calle1=$_POST['calle1'];
		$calle2=$_POST['calle2'];
		$idLogin=$_POST['idLogin'];
		
		$r = dbDriver::execQuery("
		INSERT INTO direcciones(alias, login, calle, numero, colonia,codigo_p, municipio, calle1, calle2) 
		VALUES('{$alias}',{$idLogin},'{$calle}','{$numero}','{$colonia}','{$cp}','{$municipio}','{$calle1}','{$calle2}')");
		
		if($r)
		{
			$view->dispatchMessageXML("Dirección agregada correctamente");
		}
		else
		{
			$view->dispatchErrorXML("No se pudo crear la direccion intentelo de nuevo más tarde.");
		}
		
		
	}
}
