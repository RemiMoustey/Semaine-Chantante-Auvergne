<?php
namespace App;
require_once 'vendor/autoload.php';

use controller\RegistrationController;

// Routing
$registrationController = new RegistrationController();

// Rendu du template
$loader = new \Twig_Loader_Filesystem(__DIR__  . '\views\templates');

$twig = new \Twig_Environment($loader, [
    'debug' => true,
    'cache' => false
]);

if (isset($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'home':
            echo $twig->render('home.twig');
            break;
        case 'registration':
            echo $twig->render('registration.twig');
            break;
        case 'search':
            echo $twig->render('search.twig');
            break;
        case 'readuser':
            $infos = $registrationController->listInformationUsers($_GET['id']);
            break;
        case 'adduser':
            if (!empty($_POST['surname']) AND !empty($_POST['firstname']) AND !empty($_POST['user_address']) AND !empty($_POST['postal_code']) AND 
            !empty($_POST['town']) AND !empty($_POST['phone_number']) AND isset($_POST['music_stand']) AND isset($_POST['status'])
            AND !empty($_POST['email']) AND !empty($_POST['birthday']) AND !empty($_POST['choir_name']) AND !empty($_POST['choir_town'])
            AND isset($_POST['payment']))
            {
                $registrationController->addRegistration(strtoupper($_POST['surname']), $_POST['firstname'], $_POST['user_address'], $_POST['postal_code'],
                strtoupper($_POST['town']), $_POST['phone_number'], $_POST['phone_number_office'], $_POST['music_stand'],
                $_POST['status'], $_POST['email'], $_POST['birthday'], $_POST['choir_name'],
                $_POST['choir_town'], $_POST['additional'], $_POST['payment']);
            }
            else
            {
                echo "<p>Erreur : tous les champs requis ne sont pas remplis.</p>";
            }
            break;
        case 'listusers':
            $users = $registrationController->listRegisteredUsers($_POST['q']);
            echo $twig->render('search.twig', ['users' => $users]);
            break;
        case 'acceptuser':
            $registrationController->acceptOneUser($_GET['id']);
            break;
        case 'deleteaccepteduser':
            $registrationController->removeAcceptedUser($_GET['id']);
            break;
        case 'deleteregistereduser':
            $registrationController->removeRegisteredUser($_GET['id']);
            break;
        case 'updateuser':
            $registrationController->updateUser($_GET['id'], $_POST['surname'], $_POST['firstname'], $_POST['user_address'], $_POST['postal_code'], $_POST['town'], $_POST['phone_number'], $_POST['phone_number_office'], $_POST['email'], $_POST['birthday'], $_POST['choir_name'], $_POST['choir_town']);
            break;
        case 'export':
            $registrationController->exportData();
            break;
        case 'newspaper':
            echo $twig->render('newspaper.twig');
            break;
        case 'photos':
            echo $twig->render('photos.twig');
            break;
        case 'animation':
            echo $twig->render('animation.twig');
            break;
        case 'accommodation':
            echo $twig->render('accommodation.twig');
            break;
        case 'goals':
            echo $twig->render('goals.twig');
        case 'communal-song':
        case 'staging':
        case 'free-time':
        case 'shows':
            echo $twig->render('program.twig', ['page' => $_GET['action']]);
            break;
        case 'songs':
            echo $twig->render('songs.twig');
            break;
        case 'videos':
            echo $twig->render('videos.twig');
            break;
        case 'login':
            $password = $registrationController->password();
            echo $twig->render('login.twig', ['password' => $password]);
            break;
        case 'infos':
            echo $twig->render('infos.twig');
            break;
        case 'questions':
            echo $twig->render('questions.twig');
            break;
        case 'contact':
            echo $twig->render('contact.php');
            break;
        default:
            echo ('Erreur 404');
    }
}
else
{
    echo $twig->render('home.twig');
}
?>