<?php
require_once 'vendor/autoload.php';

use Semaine_Chantante\Controller;
require_once('controller/RegistrationController.php');

// Routing
$registrationController = new Semaine_Chantante\Controller\RegistrationController();
$page = $_GET['action'];

// Rendu du template
$loader = new Twig_Loader_Filesystem(__DIR__  . '\views\templates');

$twig = new Twig_Environment($loader, [
    'debug' => true,
    'cache' => false
]);

if (isset($page))
{
    switch ($page)
    {
        case 'home':
            echo $twig->render('registration.twig');
            break;
        case 'test':
            echo $twig->render('test.twig');
            break;
        case 'readuser':
            $registrationController->listInformationUsers($_GET['username']);
            break;
        case 'adduser':
            if (!empty($_POST['name']) AND !empty($_POST['firstname']) AND !empty($_POST['address']) AND !empty($_POST['postal_code']) AND 
            !empty($_POST['town']) AND !empty($_POST['phone_number']) AND isset($_POST['music_stand']) AND isset($_POST['status'])
            AND !empty($_POST['email']) AND !empty($_POST['birthday']) AND !empty($_POST['choir_name']) AND !empty($_POST['choir_town'])
            AND isset($_POST['payment']))
            {
                $registrationController->addRegistration($_POST['name'], $_POST['firstname'], $_POST['address'], $_POST['postal_code'],
                $_POST['town'], $_POST['phone_number'], $_POST['phone_number_office'], $_POST['music_stand'],
                $_POST['status'], $_POST['email'], $_POST['birthday'], $_POST['choir_name'],
                $_POST['choir_town'], $_POST['additional'], $_POST['payment']);
            }
            else
            {
                echo "<p>Erreur : tous les champs requis ne sont pas remplis.</p>";
            }
            break;
        case 'listusers':
            $registrationController->listRegisteredUsers($_POST['q']);
            break;
        case 'acceptuser':
            $registrationController->acceptOneUser($_GET['username']);
            break;
        default:
            echo ('Erreur 404');
    }
}
