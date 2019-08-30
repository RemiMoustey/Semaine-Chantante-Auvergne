<?php

namespace model\Logs;
use model\PDOFactory;

class LogsManager extends PDOFactory
{
	/**
	* Sélectionne les identifiants de l'administrateur du blog
	*
	* @return array
	*/
	public function getAdminLogs()
	{
		$db = $this->getMysqlConnexion();
		$query = $db->query('SELECT * FROM logs');
		$logs = $query->fetch();

		return $logs;
	}

	public function getUserPassword()
	{
		$db = $this->getMysqlConnexion();
		$query = $db->query('SELECT hashed_password FROM passwordusers');
		$password = $query->fetch()[0];

		return $password;
	}
}