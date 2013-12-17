<?php

class sessionDriver extends driverBase {

	private static $usr = null;

	public static function started() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
			return true;

		return false;
	}

	public static function start($user = null, $pass = null) {
		session_start();
		if (self::started())
			return $_SESSION['user'];
		if (!$user || !$pass) {
			return false;
		} else {
			//ToDo replace QUERY with query selector of user in database
			self::$usr = dbDriver::execQueryObject("SELECT id,name,email,type FROM users WHERE username='".$user."' AND password='".md5($pass)."' LIMIT 1");
			if (!self::$usr) {
				session_destroy();
				return false;
			} else {
				$datetime = date("Y-m-d H:i:s");
				dbDriver::execQuery("UPDATE users SET login=1,last_login='{$datetime}' WHERE username='".$user."'");
				$_SESSION['logged'] = true;
				self::$usr->login = $datetime;
				$_SESSION['user'] = self::$usr;
				return self::$usr;
			}
		}
	}

	public static function getUser() {
		if (self::started())
			return $_SESSION['user'];
		else
			return false;
	}

	public static function close() {
		session_start();
		$_SESSION['logged'] = false;
		session_destroy();
		unset($_SESSION);
	}

}
