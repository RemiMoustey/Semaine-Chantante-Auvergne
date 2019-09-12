<?php

namespace model\Registration;
use model\PDOFactory;

/**
 * Interagit avec l'ensemble des informations des utilisateurs que souhaite récupérer l'administrateur lors des inscriptions.
 * 
 * @author  Rémi Moustey <remimoustey@gmail.com>
 */
class RegistrationManager extends PDOFactory
{
    /**
     * Ajoute un utilisateur dans la base de données après son inscription.
     *
     * @param  string $surname
     * @param  string $firstname
     * @param  string $password
     * @param  string $address
     * @param  string $postalCode
     * @param  string $town
     * @param  string $phoneNumber
     * @param  string $phoneNumberOffice
     * @param  string $musicStand
     * @param  string $status
     * @param  string $email
     * @param  string $birthday
     * @param  string $choirName
     * @param  string $choirTown
     * @param  string $additional
     * @param  string $payment
     *
     * @return PDOStatement
     */
    public function insertRegisteredUser($surname, $firstname, $password, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("INSERT INTO chorists(surname, firstname, hashed_password, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment, paid)
        VALUES(:surname, :firstname, :hashed_password, :user_address, :postal_code, :town, :phone_number, :phone_number_office, :music_stand, :status, :email, :birthday, :choir_name, :choir_town, :additional, :payment, :paid)");
        $registration = $query->execute(['surname' => $surname, 'firstname' => $firstname, 'hashed_password' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]), 'user_address' => $address, 'postal_code' => $postalCode, 'town' => $town, 'phone_number' => $phoneNumber, 'phone_number_office' => $phoneNumberOffice, 'music_stand' => $musicStand, 'status' => $status, 'email' => $email, 'birthday' => $birthday, 'choir_name' => $choirName, 'choir_town' => $choirTown, 'additional' => $additional, 'payment' => $payment, 'paid' => 'Non payé']);

        return $registration;
    }

    /**
     * Récupère les informations d'un utilisateur enregistrées dans la base de données.
     *
     * @param  string $id
     *
     * @return PDOStatement
     */
    public function getInfos($id)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("SELECT id, surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment, paid
        FROM chorists WHERE id LIKE \"%$id%\"");

        return $query;
    }

    /**
     * Sélectionne une liste d'utilisateurs qui correspondent à la recherche de l'administrateur.
     *
     * @param  string $q
     *
     * @return PDOStatement
     */
    public function getUsers($q)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("SELECT id, surname, firstname FROM chorists WHERE surname LIKE :surname OR firstname LIKE :firstname ORDER BY surname");
        $query->execute(['surname' => '%' . $q . '%', 'firstname' => '%' . $q . '%']);

        return $query;
    }

    /**
     * Sélectionne les utilisateurs dont l'inscription a été validée.
     *
     * @return PDOStatement
     */
    public function getAcceptedUsers()
    {
        return $this->getMySqlConnexion()->query("SELECT * FROM chorists WHERE paid='Payé'")->fetchAll();
    }

    /**
     * acceptUser
     *
     * @param  string $id
     *
     * @return PDOStatement
     */
    public function acceptUser($id)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("UPDATE chorists SET paid='Payé' WHERE id=$id");
    
        return $insertedUser;
    }

    /**
     * Supprime un utilisateur et ses informations de la base de données.
     *
     * @param  string $id
     *
     * @return void
     */
    public function deleteRegisteredUser($id)
    {
        $db = $this->getMySqlConnexion();
        $db->exec("DELETE FROM chorists WHERE id = $id");
    }

    /**
     * Met à jour le statut d'un utilisateur dont le règlement a été refusé.
     *
     * @param  string $id
     *
     * @return void
     */
    public function deleteAcceptedUser($id)
    {
        $db = $this->getMySqlConnexion();
        $db->exec("UPDATE chorists SET paid='Non payé' WHERE id=$id");
    }

    /**
     * Modifie les informations d'un utilisateur.
     *
     * @param  string $id
     * @param  string $surname
     * @param  string $firstname
     * @param  string $address
     * @param  string $postalCode
     * @param  string $town
     * @param  string $phoneNumber
     * @param  string $phoneNumberOffice
     * @param  string $email
     * @param  string $birthday
     * @param  string $choirName
     * @param  string $choirTown
     *
     * @return void
     */
    public function modifyUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("UPDATE chorists
        SET surname = :surname, firstname = :firstname,
        user_address = :user_address, postal_code = :postal_code,
        town = :town, phone_number = :phone_number,
        phone_number_office = :phone_number_office, email = :email,
        birthday = :birthday, choir_name = :choir_name,
        choir_town = :choir_town WHERE id=$id");
        $query->execute(array(':surname' => $surname, ':firstname' => $firstname,
        ':user_address' => $address, ':postal_code' => $postalCode,
        ':town' =>  $town, ':phone_number' => $phoneNumber,
        ':phone_number_office' => $phoneNumberOffice, ':email' => $email,
        ':birthday' => $birthday, ':choir_name' => $choirName,
        ':choir_town' => $choirTown));
    }

    /**
     * Sélectionne les informations des utilisateurs que l'administrateur souhaite regrouper dans un fichier Excel.
     *
     * @return PDOStatement
     */
    public function exportByCSV()
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("SELECT surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, email, paid FROM chorists");

        return $query;
    }
}