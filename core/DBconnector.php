<?php

namespace core;

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
			$res =  new \PDO($dsn, 'root', '6946ekopro');
			return $res;
	}
}
