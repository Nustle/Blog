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
			$dsn = sprintf('%s:host=%s;dbname=%s', 'mysql', 'localhost', 'blog');
			$opt = [
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
			];

			return new \PDO($dsn, 'root', '6946ekopro', $opt);
	}
}
