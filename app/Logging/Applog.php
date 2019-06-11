<?php

namespace App\Logging;

use App\Applog as log;

abstract class Applog {

	private static function log(string $msg, string $type, array $data = NULL)
	{
		log::create([
			'type' => $type,
			'message' => $msg,
			'data' => ($data ? json_encode($data): NULL)
		]);
	}

	public static function emergency(string $msg, array $data = NULL)
	{
		self::log($msg, 'emergency', $data);
	}

	public static function alert(string $msg, array $data = NULL)
	{
		self::log($msg, 'alert', $data);
	}

	public static function critical(string $msg, array $data = NULL)
	{
		self::log($msg, 'critical', $data);
	}

	public static function error(string $msg, array $data = NULL)
	{
		self::log($msg, 'error', $data);
	}

	public static function warning(string $msg, array $data = NULL)
	{
		self::log($msg, 'warning', $data);
	}

	public static function notice(string $msg, array $data = NULL)
	{
		self::log($msg, 'notice', $data);
	}

	public static function info(string $msg, array $data = NULL)
	{
		self::log($msg, 'info', $data);
	}

	public static function debug(string $msg, array $data = NULL)
	{
		self::log($msg, 'debug', $data);
	}

}

