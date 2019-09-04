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
	public function getAdminPassword($adminEmail)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('SELECT hashed_password FROM logsadmin WHERE email = :email');
		$adminPassword = $query->execute(['email' => $adminEmail]);
		$adminPassword = $query->fetch()[0];

		return $adminPassword;
	}

	public function getUserPassword($userEmail)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('SELECT hashed_password FROM chorists WHERE email = :email');
		$password = $query->execute(['email' => $userEmail]);
		$password = $query->fetch()[0];

		return $password;
	}

	public function getUserEmail($email)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('SELECT email FROM chorists WHERE email = :email');
		$foundEmail = $query->execute(['email' => $email]);
		$email = $query->fetch()[0];

		return $email;
	}

	public function modifyPassword($email, $newPassword)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('UPDATE chorists SET hashed_password = :new_password WHERE email = :email');
		$query->execute(['new_password' => $newPassword, 'email' => $email]);
	}
}