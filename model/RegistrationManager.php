<?php

namespace Semaine_Chantante\Model;
require_once('PDOFactory.php');

class RegistrationManager extends PDOFactory
{
    public function insertRegisteredUser($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("INSERT INTO chorists(surname, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment, paid)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $registration = $query->execute(array($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment, 0));

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
        $query = $db->query("SELECT id, surname, firstname FROM chorists WHERE surname LIKE \"%$q%\" OR firstname LIKE \"%$q%\" ORDER BY surname");

        return $query;
    }

    public function getAcceptedUsers()
    {
        return $this->getMySqlConnexion()->query("SELECT * FROM chorists WHERE paid=1")->fetchAll();
    }

    public function acceptUser($id)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("UPDATE chorists SET paid=1 WHERE id=$id");
    
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
        $db->exec("UPDATE chorists SET paid=0 WHERE id=$id");
    }

    public function modifyUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown)
    {
        $db = $this->getMySqlConnexion();
        $db->exec("UPDATE chorists
        SET surname = '$surname', firstname = '$firstname',
        user_address = '$address', postal_code = '$postalCode',
        town = '$town', phone_number = '$phoneNumber',
        phone_number_office = '$phoneNumberOffice', email = '$email',
        birthday = '$birthday', choir_name = '$choirName',
        choir_town = '$choirTown' WHERE id=$id");
    }
}