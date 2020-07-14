<?php

namespace App;

/*
 * Class MailService
 */

class MailService {

	public static function getParms() {

		$file = 'config/smtp_connect.ini';
		$parms = parse_ini_file($file, true);

		return $parms;
	}

}
