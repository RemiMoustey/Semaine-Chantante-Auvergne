<?php

namespace model\Logs;
use model\PDOFactory;

/**
 * Interagit les identifiants des utilisateurs utiles pour se connecter à l'espace membres.
 * 
 * @author  Rémi Moustey <remimoustey@gmail.com>
 */
class LogsManager extends PDOFactory
{
	/**
	* Sélectionne le mot de passe de l'administrateur du site.
	*
	* @param string $adminEmail
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

	/**
	* Sélectionne le mot de passe d'un des utilisateurs du site.
	*
	* @param string $userEmail
	*
	* @return array
	*/
	public function getUserPassword($userEmail)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('SELECT hashed_password FROM chorists WHERE email = :email');
		$password = $query->execute(['email' => $userEmail]);
		$password = $query->fetch()[0];

		return $password;
	}

	/**
	 * Sélectionne l'email d'un des utilisateurs du site afin de vérifier son identité.
	 *
	 * @param  string $email
	 *
	 * @return array
	 */
	public function getUserEmail($email)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('SELECT email FROM chorists WHERE email = :email');
		$foundEmail = $query->execute(['email' => $email]);
		$email = $query->fetch()[0];

		return $email;
	}

	/**
	 * Modifie le mot de passe d'un des utilisateurs du site s'il décide de le changer.
	 *
	 * @param  string $email
	 * @param  string $newPassword
	 *
	 * @return void
	 */
	public function modifyPassword($email, $newPassword)
	{
		$db = $this->getMysqlConnexion();
		$query = $db->prepare('UPDATE chorists SET hashed_password = :new_password WHERE email = :email');
		$query->execute(['new_password' => $newPassword, 'email' => $email]);
	}
}