<?php

class viewBase {
	public function dispatchMessageXML($str = null) {
		//$str = utf8_encode($str);
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
        echo "<mensaje value='{$str}' />";
        echo "</Message>";
		exit;
	}

	public function dispatchMessageXMLfacebook($id,$token) {
		//$str = utf8_encode($str);
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
        echo "<mensaje value='Información actualizada correctamente' />";
        echo "</Message>";
		exit;
	}
	
	public function dispatchErrorXML($str = null) {
		//$str = utf8_encode($str);
		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		echo "<Message>";
        echo "<error value='{$str}' />";
        echo "</Message>";
		exit;
	}
	
	
}
