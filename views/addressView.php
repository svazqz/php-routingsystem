<?php

class addressView
{
	public function dispatchXML($d)
	{
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
		if(count($d))
		{
			foreach ($d as $o) {
				echo utf8_encode("<direccion> 
	            <id>{$o->id}</id>  
	            <alias>{$o->alias}</alias> 
	            <calle>{$o->calle}</calle>  
	            <numero>{$o->numero}</numero>  
	            <colonia>{$o->colonia}</colonia>   
	            <cp>{$o->codigo_p}</cp> 
	            <municipio>{$o->municipio}</municipio>  
	            <calle1>{$o->calle1}</calle1>  
	            <calle2>{$o->calle2}</calle2>
	            </direccion>");
			}
		}
		else 
		{
			echo "<error value='No hay direcciones registradas' />";
		}
    
    	echo "</Message>";
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
