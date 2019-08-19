<?php

namespace Semaine_Chantante\Controller;
use \Semaine_Chantante\Model;

require_once('model/RegistrationManager.php');

class RegistrationController
{
    public function addRegistration($name, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();

        $newRegisteredUser = $registrationManager->insertRegisteredUser($name, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment);
    
        if ($newRegisteredUser === false)
        {
            throw new Exception("Impossible d'ajouter le nouvel utilisateur enregistré.");
        }
        else
        {
            header('Location: index.php?action=home');
        }
    }

    public function listInformationUsers($username)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $infos = $registrationManager->getInfos($username);

        require('views/templates/infos.php');
    }

    public function listRegisteredUsers($q)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $users = $registrationManager->getUsers($q);

        require('views/templates/test.php');
    }

    public function acceptOneUser($username)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $userAccepted = $registrationManager->insertAcceptedUser($username);

        if ($userAccepted === false)
        {
            throw new Exception("Impossible d'accepter l'utilisateur.");
        }
        elseif ($userAccepted === "already")
        {
            echo "<p>L'utilisateur a déjà été accepté.</p>";
        }
        else
        {
            header('Location: index.php?action=test');
        }
    }
}