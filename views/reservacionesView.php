<?php

class reservacionesView
{
	public function index()
	{
		$procesados = dbDriver::execQueryObject("
		select 
		r.id as id, 
		r.hora_sali as hora_solicitada, 
		r.type as tipo, 
		r.fecha as fecha, 
		r.hora_servi as hora, 
		r.pasajeros as pasajeros, 
		r.vehiculo as vehiculo, 
		r.terminal as terminal, 
		r.aerolinea as aerolinea, 
		r.no_vuelo as no_vuelo, 
		r.hora_salida as hora_salida, 
		r.estatus as status, 
		d.calle as calle, 
		d.numero as numero, 
		d.colonia as colonia, 
		d.codigo_p as cp, 
		d.municipio as municipio, 
		d.calle1 as entre1, 
		d.calle2 as entre2, 
		l.id as uid, 
		l.nombre as nombre, 
		l.correo as correo, 
		l.telefono as telefono 
		from 
		(logins l inner join reservaciones r on (r.login = l.id) and (l.id)) 
		inner join direcciones d on r.direccion = d.id 
		where r.estatus=1
		", true);
		$pendientes = dbDriver::execQueryObject("
		select 
		r.id as id, 
		r.hora_sali as hora_solicitada, 
		r.type as tipo, 
		r.fecha as fecha, 
		r.hora_servi as hora, 
		r.pasajeros as pasajeros, 
		r.vehiculo as vehiculo, 
		r.terminal as terminal, 
		r.aerolinea as aerolinea, 
		r.no_vuelo as no_vuelo, 
		r.hora_salida as hora_salida, 
		r.estatus as status, 
		d.calle as calle, 
		d.numero as numero, 
		d.colonia as colonia, 
		d.codigo_p as cp, 
		d.municipio as municipio, 
		d.calle1 as entre1, 
		d.calle2 as entre2, 
		l.id as uid, 
		l.nombre as nombre, 
		l.correo as correo, 
		l.telefono as telefono 
		from 
		(logins l inner join reservaciones r on (r.login = l.id) and (l.id)) 
		inner join direcciones d on r.direccion = d.id 
		where r.estatus=0
		", true);
		echo "<style>

		table { 
		
		color: #333;
		font-family: Helvetica, Arial, sans-serif;
		font-size: 12px;
		width: 640px; 
		border:10px solid #DFDFDF;
		        
		-webkit-border-bottom-left-radius:25px;
		-webkit-border-bottom-right-radius:25px;
		-webkit-border-top-right-radius:25px;
		-moz-border-radius-topleft:25px;
		-webkit-border-top-left-radius:25px; 
		
		}
		
		td, th { 
		border: 1px solid transparent;
		height: 30px; 
		transition: all 0.3s; 
		}
		
		th {
		        
			color:0C73AB;
		
		background: #DFDFDF;  /* Darken header a bit */
		font-weight: bold;
		}
		
		td {
		background: #FAFAFA;
		text-align: center;
		}
		
		
		tr:nth-child(even) td { background: #F1F1F1; background-color: #DFDFDF }   
		
		/* Cells in odd rows (1,3,5...) are another (excludes header cells)  */ 
		tr:nth-child(odd) td { background: #FEFEFE; }  
		
		tr td:hover { background: #666; color: #FFF; }
		</style>";
		echo "<h1>Pendientes</h1>";
		echo "<center><table>
		<tr>
                    <th>&nbsp;<b>Usuario</b></Th>
                    <th>&nbsp;<b>Tipo&nbsp;de&nbsp;servicio</b></Th>
                    <th>&nbsp;<b>Direcci&oacute;n</b></Th>
                    <th>&nbsp;<b>Fecha</b></Th>
                    <th>&nbsp;<b>Hora</b></Th>
                    <th>&nbsp;<b>Pasajeros</b></Th>
                    <th>&nbsp;<b>Veh&iacute;culo</b></Th>
                    <th>&nbsp;<b>Datos&nbsp;del&nbsp;vuelo</b></Th>
                    <th>&nbsp;<b>Confirmar</b></Th>
                </tr>";
                
        
                
		foreach ($pendientes as $o) {
			echo "<tr>";
			$hora = explode(":", $o->hora_solicitada);
                            $h = sprintf('%2u',($hora[0] + 2));
                            $hora = $h . ":" .$hora[1];
			echo utf8_decode("
            <tr>
            	<td>
            		<b>
            			Nombre: {$o->nombre}<br />
            			Correo: {$o->correo}<br />
            			Teléfono: {$o->telefono}<br />
            			Hora de solicitud: {$hora}<br />
            		</b>
            	</td>
                <td><b>". listDriver::getValue('destinos', $o->tipo) ."</b></td>
                <td>
            		<b>
            			Calle: {$o->calle}<br />
            			Número: {$o->numero}<br />
            			Colonia: {$o->colonia}<br />
            			Municipio: {$o->municipio}<br />
            			CP: {$o->cp}<br />
            			Entre {$o->entre1} y {$o->entre2}<br />
            		</b>
            	</td>
                <td><b>{$o->fecha}</b></td>
                <td><b>{$o->hora}</b></td>
                <td><b>{$o->pasajeros}</b></td>
                <td><b>".listDriver::getValue('vehiculos',$o->vehiculo)."</b></td>
                <td>
	                <b>
		                Terminal: {$o->terminal}<br />
		                Aerolínea: {$o->aerolinea}<br />
		                Número de vuelo: {$o->no_vuelo}<br />
		                Hora de salida: {$o->hora_salida}<br />
	                </b>
                </td>
                <td>
                	<a href='reservaciones/proccess/{$o->id}'>
                		<img src=images/correcto.png width=48 height=48 />
                	</a>
                </td>
			");
				
			echo "</tr>";
		}
		echo "</table></center>";
		
		unset($o);
		
		echo "<h1>Procesados</h1>";
		echo "<center><table>
		<tr>
                    <th>&nbsp;<b>Usuario</b></Th>
                    <th>&nbsp;<b>Tipo&nbsp;de&nbsp;servicio</b></Th>
                    <th>&nbsp;<b>Direcci&oacute;n</b></Th>
                    <th>&nbsp;<b>Fecha</b></Th>
                    <th>&nbsp;<b>Hora</b></Th>
                    <th>&nbsp;<b>Pasajeros</b></Th>
                    <th>&nbsp;<b>Veh&iacute;culo</b></Th>
                    <th>&nbsp;<b>Datos&nbsp;del&nbsp;vuelo</b></Th>
                </tr>";
                
        
        if(count($procesados))      
		foreach ($procesados as $o) {
			echo "<tr>";
			$hora = explode(":", $o->hora_solicitada);
                            $h = sprintf('%2u',($hora[0] + 2));
                            $hora = $h . ":" .$hora[1];
			echo utf8_decode("
            <tr>
            	<td>
            		<b>
            			Nombre: {$o->nombre}<br />
            			Correo: {$o->correo}<br />
            			Teléfono: {$o->telefono}<br />
            			Hora de solicitud: {$hora}<br />
            		</b>
            	</td>
                <td><b>". listDriver::getValue('destinos', $o->tipo) ."</b></td>
                <td>
            		<b>
            			Calle: {$o->calle}<br />
            			Número: {$o->numero}<br />
            			Colonia: {$o->colonia}<br />
            			Municipio: {$o->municipio}<br />
            			CP: {$o->cp}<br />
            			Entre {$o->entre1} y {$o->entre2}<br />
            		</b>
            	</td>
                <td><b>{$o->fecha}</b></td>
                <td><b>{$o->hora}</b></td>
                <td><b>{$o->pasajeros}</b></td>
                <td><b>".listDriver::getValue('vehiculos',$o->vehiculo)."</b></td>
                <td>
	                <b>
		                Terminal: {$o->terminal}<br />
		                Aerolínea: {$o->aerolinea}<br />
		                Número de vuelo: {$o->no_vuelo}<br />
		                Hora de salida: {$o->hora_salida}<br />
	                </b>
                </td>
			");
				
			echo "</tr>";
		}
		echo "</table></center>";
	}
	
	public function dispatchMessageXML($srt = null)
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
        echo "<mensaje value='{$str}' />";
        echo "</Message>";
	}
	
	public function dispatchErrorXML($str = null)
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
        echo "<error value='{$str}' />";
        echo "</Message>";
		exit;
	}
}
