<?php

class sessionDriver extends driverBase {

	public static function started() {
		session_start();
		if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
			return true;

		return false;
	}

	public static function start($user = null, $pass = null) {
		session_start();
		if (self::started())
			return null;
		if (!$user || !$pass) {
			return "Debes especificar tu usuario o tu contraseña";
		} else {
			//ToDo replace QUERY with query selector of user in database
			$usuario = dbDriver::execQueryObject("QUERY");
			if (!$usuario) {
				return "Usuario y/o contraseña incorrectos";
			} else {
				return $usuario;
			}
		}

	}

	public static function close() {
		session_start();
		$_SESSION['logged'] = false;
		session_destroy();
		unset($_SESSION);
	}

}
