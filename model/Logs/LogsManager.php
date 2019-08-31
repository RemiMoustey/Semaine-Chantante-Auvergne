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
	public function getAdminPassword()
	{
		$db = $this->getMysqlConnexion();
		$query = $db->query('SELECT hashed_password FROM passwordadmin');
		$adminPassword = $query->fetch()[0];

		return $adminPassword;
	}

	public function getUserPassword()
	{
		$db = $this->getMysqlConnexion();
		$query = $db->query('SELECT hashed_password FROM passwordusers');
		$password = $query->fetch()[0];

		return $password;
	}
}