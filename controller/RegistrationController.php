<?php

namespace Semaine_Chantante\Controller;
use \Semaine_Chantante\Model;

require_once('model/RegistrationManager.php');

class RegistrationController
{
    protected $loader;
    protected $twig;

    public function __construct()
    {
        // Rendu du template
        $this->loader = new \Twig_Loader_Filesystem('C:\wamp64\www\projet5\views\templates');
        $this->twig = new \Twig_Environment($this->loader, [
            'debug' => true,
            'cache' => false
        ]);
    }

    public function addRegistration($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();

        $newRegisteredUser = $registrationManager->insertRegisteredUser($surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment);
    
        if ($newRegisteredUser === false)
        {
            throw new Exception("Impossible d'ajouter le nouvel utilisateur enregistré.");
        }
        else
        {
            header('Location: index.php?action=home');
        }
    }

    public function listInformationUsers($id)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $infos = $registrationManager->getInfos($id);
        $acceptedUsers = $registrationManager->getAcceptedUsers();
        
        require('views/templates/infos.php');
    }

    public function listRegisteredUsers($q)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $users = $registrationManager->getUsers($q);
        echo $this->twig->render('test.twig', ['users' => $users->fetchAll()]);
    }

    public function acceptOneUser($id)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
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
            header('Location: index.php?action=test');
        }
    }

    public function removeAcceptedUser($id)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $user = $registrationManager->deleteAcceptedUser($id);

        if ($user === false)
        {
            throw new Exception ("Impossible de supprimer l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=test');
        }
    }

    public function removeRegisteredUser($id)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $user = $registrationManager->deleteRegisteredUser($id);

        if ($user === false)
        {
            throw new Exception ("Impossible de supprimer l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=test');
        }
    }

    public function updateUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown)
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
        $user = $registrationManager->modifyUser($id, $surname, $firstname, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $email, $birthday, $choirName, $choirTown);

        if ($user === false)
        {
            throw new Exception("Impossible de modifier les informations de l'utilisateur.");
        }
        else
        {
            header('Location: index.php?action=test');
        }
    }

    public function exportData()
    {
        $registrationManager = new \Semaine_Chantante\Model\RegistrationManager();
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