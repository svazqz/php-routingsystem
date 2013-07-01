<?php



class mailDriver extends driverBase

{

	public static function send($to = null, $title = null, $message = null, $headers = null)

	{

		$mc = configDriver::getMailConfig();

		if($mc["method"] == "mail")

		{

			//Method mail

			self::sendMail($to, $title, $message, $headers);

		}

		elseif($mc["method"] == "smtp")

		{

			//SMTP server

		}

		else 

		{
			//Not valid
		}

	}

	

	private static function sendMail($to = null, $title = null, $message = null, $headers = null)

	{

		$headers2 = "";

		foreach ($headers as $key => $value) {
			$headers2 .= "{$key}: {$value}\r\n";
		}

		if(mail($to, $title, $message, $headers2))return true;

		return false;

	}

	

	private static function sendSMTP()

	{

		

	}

}

