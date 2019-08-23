<?php

namespace Blog\Core;

class DBconnector
{
	private static $instance;

	public static function getConnect()
	{
		if (self::$instance === null) {
			self::$instance = self::getPDO();
		}

		return self::$instance;
	}
	
	public static function getPDO()
	{
		$opt = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		];

		$dsn = sprintf('%s:host=%s;dbname=%s', 'mysql', getenv('DB_HOST'), getenv('DB_NAME'));
		
		return new \PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'), $opt);
	}
}
