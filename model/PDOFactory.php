<?php

namespace Semaine_Chantante\Model;

abstract class PDOFactory
{
	public static function getMysqlConnexion()
	{
		$db = new \PDO('mysql:host=localhost;dbname=semaine_chantante;charset=utf8', 'root', '');
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}