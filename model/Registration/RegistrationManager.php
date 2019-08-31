<?php

namespace model\Registration;
use model\PDOFactory;

class RegistrationManager extends PDOFactory
{
    public function insertRegisteredUser($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("INSERT INTO chorists(surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment, paid)
        VALUES(:surname, :firstname, :user_address, :postal_code, :town, :phone_number, :phone_number_office, :music_stand, :status, :email, :birthday, :choir_name, :choir_town, :additional, :payment, :paid)");
        $registration = $query->execute(['surname' => $surname, 'firstname' => $firstname, 'user_address' => $address, 'postal_code' => $postalCode, 'town' => $town, 'phone_number' => $phoneNumber, 'phone_number_office' => $phoneNumberOffice, 'music_stand' => $musicStand, 'status' => $status, 'email' => $email, 'birthday' => $birthday, 'choir_name' => $choirName, 'choir_town' => $choirTown, 'additional' => $additional, 'payment' => $payment, 'paid' => 'Non payé']);

        return $registration;
    }

    public function getInfos($id)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("SELECT id, surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment, paid
        FROM chorists WHERE id LIKE \"%$id%\"");

        return $query;
    }

    public function getUsers($q)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("SELECT id, surname, firstname FROM chorists WHERE surname LIKE :surname OR firstname LIKE :firstname ORDER BY surname");
        $query->execute(['surname' => '%' . $q . '%', 'firstname' => '%' . $q . '%']);

        return $query;
    }

    public function getAcceptedUsers()
    {
        return $this->getMySqlConnexion()->query("SELECT * FROM chorists WHERE paid='Payé'")->fetchAll();
    }

    public function acceptUser($id)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("UPDATE chorists SET paid='Payé' WHERE id=$id");
    
        return $insertedUser;
    }

    public function deleteRegisteredUser($id)
    {
        $db = $this->getMySqlConnexion();
        $db->exec("DELETE FROM chorists WHERE id = $id");
    }

    public function deleteAcceptedUser($id)
    {
        $db = $this->getMySqlConnexion();
        $db->exec("UPDATE chorists SET paid='Non payé' WHERE id=$id");
    }

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

    public function exportByCSV()
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("SELECT surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, email, paid FROM chorists");

        return $query;
    }
}