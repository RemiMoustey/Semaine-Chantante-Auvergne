<?php
include('auth.php');
session_start();
if(isAuthenticatedAdmin())
{
    unset($_SESSION['authenticatedAdmin']);
}
elseif (isAuthenticatedUser())
{
    unset($_SESSION['authenticatedUser']);
}

header('Location: index.php');