<?php

class fbController extends controllerBase
{

	private function getRemoteFile($url, $timeout = 10) {
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		return ($file_contents) ? $file_contents : FALSE;
	}

	public function index()
	{
		$id_usuario = "293803966478";
		$respuesta = file_get_contents("http://graph.facebook.com/" . $id_usuario . "/feed");

		$datos = json_decode($respuesta,true);

		$facebook = array();
		$i = 0;
		foreach ($datos["data"] as $value) {
			if (trim($value["picture"]) != "") {
				$facebook[$i]["src"] = trim($value["picture"]);
				$facebook[$i]["titulo"] = trim($value["name"]);
				$facebook[$i]["texto"] = trim($value["description"]);
				$i++;
			}
			if ($i>4) break;
		}
		$html = "";
		foreach ($facebook as $key => $value) {
			$html .= '
				<div>
					<h1>'.$value["titulo"].'</h1>
					<img src="' . $value["src"] . '" alt="' . $value["titulo"] . '" />
					<div>'.$value["texto"].'</div>
				</div>
			';
		}

		echo $html;
	}
}


