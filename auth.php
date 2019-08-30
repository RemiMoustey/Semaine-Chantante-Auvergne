<?php
/**
  * Ce fichier vérifie si l'utilisateur ou l'administrateur est authentifié et donc, s'il a accès
  * à l'espace réservé ou à l'interface d'administration.
  * @author  Rémi Moustey <remimoustey@gmail.com>
  */

/* function isAuthenticated($index)
{
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION[$index]);
}

function authenticated($index)
{
    if ($index === 'login')
    {
        if(!isAuthenticatedAdmin())
        {
            header('Location: index.php?action=login');
            exit();
        }
    }
    elseif ($index === 'login-user')
    {
        if(!isAuthenticatedUser())
        {
            header('Location: index.php?action=login-user');
            exit();
        }
    }
} */

function isAuthenticatedAdmin()
{
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION['authenticatedAdmin']);
}

function authenticatedAdmin()
{
    if(!isAuthenticatedAdmin())
    {
        header('Location: index.php?action=login');
        exit();
    }
}

function isAuthenticatedUser()
{
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION['authenticatedUser']);
}

function authenticatedUser()
{
    if(!isAuthenticatedUser())
    {
        header('Location: index.php?action=login-user');
        exit();
    }
}