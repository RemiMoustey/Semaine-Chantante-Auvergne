<?php

namespace controller;

use model\Registration\RegistrationManager;
use model\Logs\LogsManager;

require './vendor/autoload.php';

class RegistrationController
{  
    public function addRegistration($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $registrationManager = new RegistrationManager();

        $newRegisteredUser = $registrationManager->insertRegisteredUser($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment);
    
        if ($newRegisteredUser === false)
        {
            throw new Exception("Impossible d'ajouter le nouvel utilisateur enregistré.");
        }
        else
        {
            header('Location: index.php?action=registration-complete');
        }
    }

    public function login()
    {
        $logsManager = new LogsManager();
        $logs = $logsManager->getAdminLogs();

        require('views/templates/login.php');
    }

    public function loginUser()
    {
        $logsManager = new LogsManager();
        $password = $logsManager->getUserPassword();

        require('views/templates/login-user.php');
    }

    public function listInformationUsers($id)
    {
        $registrationManager = new RegistrationManager();
        $infos = $registrationManager->getInfos($id);
        $acceptedUsers = $registrationManager->getAcceptedUsers();
        
        require('views/templates/infos.php');
    }

    public function listRegisteredUsers($q)
    {
        $registrationManager = new RegistrationManager();
        $users = $registrationManager->getUsers($q);
        return $users->fetchAll();
    }

    public function acceptOneUser($id)
    {
        $registrationManager = new RegistrationManager();
        $userAccepted = $registrationManager->acceptUser($id);

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
            header('Location: index.php?action=search');
        }
    }

    public function removeAcceptedUser($id)
    {
        $registrationManager = new RegistrationManager();
        $user = $registrationManager->deleteAcceptedUser($id);

        if ($user === false)
        {
            throw new Exception ("Impossible de supprimer l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=search');
        }
    }

    public function removeRegisteredUser($id)
    {
        $registrationManager = new RegistrationManager();
        $user = $registrationManager->deleteRegisteredUser($id);

        if ($user === false)
        {
            throw new Exception ("Impossible de supprimer l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=search');
        }
    }

    public function updateUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown)
    {
        $registrationManager = new RegistrationManager();
        $user = $registrationManager->modifyUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown);

        if ($user === false)
        {
            throw new Exception("Impossible de modifier les informations de l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=search');
        }
    }

    public function exportData()
    {
        $registrationManager = new RegistrationManager();
        $users = $registrationManager->exportByCSV();

        if ($users === false)
        {
            throw new Exception("Impossible d'exporter les données");
        }
        else
        {
            require('views/templates/export.php');
        }
    }
}