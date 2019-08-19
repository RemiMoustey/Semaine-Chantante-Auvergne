<?php

namespace Semaine_Chantante\Model;
require_once('PDOFactory.php');

class RegistrationManager extends PDOFactory
{
    public function insertRegisteredUser($name, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->prepare("INSERT INTO choristes_inscrits(username, firstname, user_address, postal_code, town, phone_number, phone_number_office, music_stand, status, email, birthday, choir_name, choir_town, additional, payment)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $registration = $query->execute(array($name, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment));
    
        return $registration;
    }

    public function getUsers($q)
    {
        $db = $this->getMySqlConnexion();
        $query = $db->query("SELECT username, firstname FROM choristes_inscrits WHERE username LIKE \"%$q%\" OR firstname LIKE \"%$q%\" ORDER BY username");

        return $query;
    }

    public function insertAcceptedUser($username)
    {
        $db = $this->getMySqlConnexion();
        $queryAcceptedUser = $db->query("SELECT username, firstname, user_address, user_address, postal_code, town, phone_number, phone_number_office, music_stand, email FROM choristes_inscrits WHERE username LIKE \"%$username%\"");
        $requestAcceptedUser = $queryAcceptedUser->fetch();
        $acceptedUsers = $db->query("SELECT * FROM chorists_for_excel")->fetchAll();
        $numberOfAccepted = count($acceptedUsers);
        foreach ($acceptedUsers as $acceptedUser)
        {
            if (in_array($username, $acceptedUser) === true)
            {
                return "already";
            }
        }
        $query = $db->prepare("INSERT INTO chorists_for_excel(id, username, firstname, user_address, postal_code_town, phone_number, phone_number_office, music_stand, email)
        VALUES(?,?,?,?,?,?,?,?,?)");
        $insertedUser = $query->execute(array($numberOfAccepted + 1, $username, $requestAcceptedUser['firstname'], $requestAcceptedUser['user_address'], $requestAcceptedUser['postal_code'] . " - " . strtoupper($requestAcceptedUser['town']), $requestAcceptedUser['phone_number'], $requestAcceptedUser['phone_number_office'], $requestAcceptedUser['music_stand'], $requestAcceptedUser['email']));
    
        return $insertedUser;
    }
}