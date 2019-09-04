<?php

namespace controller;

use model\Registration\RegistrationManager;
use model\Logs\LogsManager;
use model\Comments\CommentsManager;

require './vendor/autoload.php';

class RegistrationController
{  
    public function addRegistration($surname, $firstname, $password, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment)
    {
        $registrationManager = new RegistrationManager();
        
        $newRegisteredUser = $registrationManager->insertRegisteredUser($surname, $firstname, $password, $address, $postalCode, $town, $phoneNumber, $phoneNumberOffice, $musicStand, $status, $email, $birthday, $choirName, $choirTown, $additional, $payment);
    
        if ($newRegisteredUser === false)
        {
            throw new Exception("Impossible d'ajouter le nouvel utilisateur enregistré.");
        }
        else
        {
            header('Location: index.php?action=registration-complete');
        }
    }

    public function passwordUser($userEmail)
    {
        $logsManager = new LogsManager();
        $password = $logsManager->getUserPassword($userEmail);
        return $password;
    }
    
    public function passwordAdmin($adminEmail)
    {
        $logsManager = new LogsManager();
        $adminPassword = $logsManager->getAdminPassword($adminEmail);
        return $adminPassword;
    }

    public function emailUser($email)
    {
        $logsManager = new LogsManager();
        $foundEmail = $logsManager->getUserEmail($email);
        return $foundEmail;
    }

    public function updatePassword($email, $newPassword)
    {
        $logsManager = new LogsManager();
        $password = $logsManager->modifyPassword($email, $newPassword);

        if ($password === false)
        {
            throw new Exception("Impossible de modifier le mot de passe.");
        }
        else
        {
            header('Location: index.php?action=updated-password');
        }
    }

    public function listInformationUsers($id)
    {
        $registrationManager = new RegistrationManager();
        return $registrationManager->getInfos($id);
    }

    public function acceptedUsers()
    {
        $registrationManager = new RegistrationManager();
        return $registrationManager->getAcceptedUsers();
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
            header('Location: index.php?action=space-users');
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
            header('Location: index.php?action=space-users');
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
            header('Location: index.php?action=space-users');
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
            header('Location: index.php?action=space-users');
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
            require('export.php');
        }
    }

    public function comments()
    {
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getComments();
        return $comments->fetchAll();
    }

    public function countComments()
    {
        $commentsManager = new CommentsManager();
        $countComments = $commentsManager->getNumberComments();
        return $countComments;
    }

    public function notifiedComments()
    {
        $commentsManager = new CommentsManager();
        $notifiedComments = $commentsManager->getNotifiedComments();
        return $notifiedComments->fetchAll();
    }

    public function reportComment($commentId)
    {
        $commentsManager = new CommentsManager();
        $reportedComment = $commentsManager->notifyComment($commentId);
        $commentsManager->addNotifiedComment($commentId, $reportedComment['author'], $reportedComment['comment']);

        if ($reportedComment === false)
		{
			echo '<p>Impossible de signaler le commentaire.</p>';
			return;
		}

		header('Location: index.php?action=space-users');
    }

    public function addComment($author, $comment)
    {
        $commentsManager = new CommentsManager();
        $affectedLines = $commentsManager->postComment($author, $comment);
        if ($affectedLines === false)
	    {
			echo '<p>Impossible d\'ajouter le commentaire.</p>';
			return;
        }
        
        header('Location: index.php?action=space-users');
    }

    public function removeComment($commentId)
    {
        $commentsManager = new CommentsManager();
        $comment = $commentsManager->deleteComment($commentId);
        if ($comment === false)
		{
			throw new Exception("Impossible de supprimer le commentaire.");
			return;
        }

        header('Location: index.php?action=search');
    }
}