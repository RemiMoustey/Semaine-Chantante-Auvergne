<?php

namespace controller;

use model\Registration\RegistrationManager;
use model\Logs\LogsManager;
use model\Comments\CommentsManager;

require './vendor/autoload.php';

/**
 * Cette classe récupère les données qu'il demande au modèle. Il renvoie les éléments à afficher aux vues.
 * Il joue le rôle d'intermédiaire.
 * 
 * @author Rémi Moustey <remimoustey@gmail.com>
 */
class Controller
{  
    /**
     * Envoie les données entrées lors de l'inscription de l'utilisateur et amène sur une page
     * signalant que l'enregistrement est terminé.
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
     * @return void
     */
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

    /**
     * Récupère et renvoie au router le mot de passe d'un utilisateur.
     *
     * @param  string $userEmail
     *
     * @return string
     */
    public function passwordUser($userEmail)
    {
        $logsManager = new LogsManager();
        $password = $logsManager->getUserPassword($userEmail);
        return $password;
    }
    
    /**
     * Récupère et renvoie au router le mot de passe de l'administrateur.
     *
     * @param  string $adminEmail
     *
     * @return string
     */
    public function passwordAdmin($adminEmail)
    {
        $logsManager = new LogsManager();
        $adminPassword = $logsManager->getAdminPassword($adminEmail);
        return $adminPassword;
    }

    /**
     * Récupère et renvoie au router l'email d'un utilisateur.
     *
     * @param  string $email
     *
     * @return string
     */
    public function emailUser($email)
    {
        $logsManager = new LogsManager();
        $foundEmail = $logsManager->getUserEmail($email);
        return $foundEmail;
    }

    /**
     * Met à jour le mot de passe modifié d'un utilisateur.
     *
     * @param  string $email
     * @param  string $newPassword
     *
     * @return void
     */
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

    /**
     * Récupère et renvoie au routeur les informations d'un choriste.
     *
     * @param  string $id
     *
     * @return PDOStatement
     */
    public function listInformationUsers($id)
    {
        $registrationManager = new RegistrationManager();
        return $registrationManager->getInfos($id);
    }

    /**
     * Récupère et renvoie au router la liste des utilisateurs dont l'inscription a été validée.
     *
     * @return PDOStatement
     */
    public function acceptedUsers()
    {
        $registrationManager = new RegistrationManager();
        return $registrationManager->getAcceptedUsers();
    }

    /**
     * Récupère la liste des utilisateurs enregistrés et la renvoie sous forme de tableau.
     *
     * @param  string $q
     *
     * @return array
     */
    public function listRegisteredUsers($q)
    {
        $registrationManager = new RegistrationManager();
        $users = $registrationManager->getUsers($q);
        return $users->fetchAll();
    }

    /**
     * Demande au modèle d'accepter l'inscription d'un utilisateur.
     *
     * @param  string $id
     *
     * @return void
     */
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

    /**
     * Demande au modèle de supprimer un utilisateur accepté.
     *
     * @param  string $id
     *
     * @return void
     */
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

    /**
     * Demande au modèle de supprimer un utilisateur inscrit.
     *
     * @param  string $id
     *
     * @return void
     */
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

    /**
     * Demande au modèle de modifier les données enregistrées lors de l'inscription d'un utilisateur.
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

    /**
     * Deamdne la sélection des informations de l'ensemble des utilisateurs inscrits afin de construire un
     * fichier Excel les rassemblant.
     *
     * @return void
     */
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

    /**
     * Récupère l'ensemble des commentaires et les renvoie sous forme de tableau.
     *
     * @return array
     */
    public function comments()
    {
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getComments();
        return $comments->fetchAll();
    }

    /**
     * Renvoie une requête permettant de compter le nombre de commentaires postés.
     *
     * @return PDOStatement
     */
    public function countComments()
    {
        $commentsManager = new CommentsManager();
        $countComments = $commentsManager->getNumberComments();
        return $countComments;
    }

    /**
     * Récupère les commentaires signalés et les renvoie sous forme de tableau.
     *
     * @return array
     */
    public function notifiedComments()
    {
        $commentsManager = new CommentsManager();
        $notifiedComments = $commentsManager->getNotifiedComments();
        return $notifiedComments->fetchAll();
    }

    /**
     * Demande l'insertion d'un commentaire dans la table des commentaires signalés.
     *
     * @param  string $commentId
     *
     * @return void
     */
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

    /**
     * Demande l'insertion d'un commentaire.
     *
     * @param  string $author
     * @param  string $comment
     *
     * @return void
     */
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

    /**
     * Demande la suppression d'un commentaire.
     *
     * @param  string $commentId
     *
     * @return void
     */
    public function removeComment($commentId)
    {
        $currentPage = $_GET['action'];
        $commentsManager = new CommentsManager();
        
        $comment = $commentsManager->deleteComment($commentId);
        if ($comment === false)
		{
			throw new Exception("Impossible de supprimer le commentaire.");
			return;
        }

        header('Location: index.php?action=comments-admin');
    }
}