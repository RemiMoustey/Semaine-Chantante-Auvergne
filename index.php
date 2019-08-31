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

require_once('auth.php');

if (isset($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'home':
            echo $twig->render('home.twig');
            break;
        case 'login-user':
            $registrationController->loginUser();
            break;
        case 'registration':
            echo $twig->render('registration.twig');
            break;
        case 'registration-complete':
            echo $twig->render('registrationComplete.twig');
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
            authenticatedAdmin();
            $users = $registrationController->listRegisteredUsers($_POST['q']);
            $comments = $registrationController->comments();
            $notifiedComments = $registrationController->notifiedComments();
            echo $twig->render('search.twig', ['users' => $users, 'comments' => $comments, 'notifiedComments' => $notifiedComments]);
            break;
        case 'acceptuser':
            authenticatedAdmin();
            $registrationController->acceptOneUser($_GET['id']);
            break;
        case 'deleteaccepteduser':
            authenticatedAdmin();
            $registrationController->removeAcceptedUser($_GET['id']);
            break;
        case 'deleteregistereduser':
            authenticatedAdmin();
            $registrationController->removeRegisteredUser($_GET['id']);
            break;
        case 'updateuser':
            authenticatedAdmin();
            $registrationController->updateUser($_GET['id'], $_POST['surname'], $_POST['firstname'], $_POST['user_address'], $_POST['postal_code'], $_POST['town'], $_POST['phone_number'], $_POST['phone_number_office'], $_POST['email'], $_POST['birthday'], $_POST['choir_name'], $_POST['choir_town']);
            break;
        case 'export':
            authenticatedAdmin();
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
            break;
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
        case 'infos':
            echo $twig->render('infos.twig');
            break;
        case 'questions':
            echo $twig->render('questions.twig');
            break;
        case 'space-users':
            $user = null;
            if(isAuthenticatedUser())
            {
                authenticatedUser();
                $user = 'chorist';
            }
            else if(isAuthenticatedAdmin())
            {
                authenticatedAdmin();
                $user = 'admin';
            }
            else
            {
                $registrationController->loginUser();
                break;
            }
            $comments = $registrationController->comments();
            $countComments = $registrationController->countComments();
            $count = $countComments->fetch()[0];
            $pages = ceil($count / PER_PAGE);
            $page = (int)($_GET['p'] ?? 1);
            $notifiedComments = $registrationController->notifiedComments();
            echo $twig->render('space-users.twig', ['user' => $user, 'comments' => $comments, 'pages' => $pages, 'page' => $page, 'notifiedComments' => $notifiedComments]);
            break;
        case 'notify-comment':
            authenticatedUser();
            if (isset($_GET['id']) AND $_GET['id'] > 0)
            {
                $registrationController->reportComment($_GET['id']);
            }
            else
            {
                echo "<p>Erreur : aucun identifiant de commentaire n'a été envoyé</p>";
            }
            break;
        case 'add-comment':
            authenticatedUser();
            if (!empty($_POST['author']) AND !empty($_POST['comment']))
            {
                $registrationController->addComment($_POST['author'], $_POST['comment']);
            }
            else
            {
                echo "<p>Erreur : tous les champs ne sont pas remplis.</p>";
            }
            break;
        case 'removeComment':
            authenticatedUser();
            if (isset($_GET['id']) AND $_GET['id'] > 0)
            {
                $registrationController->removeComment($_GET['id']);
            }
            else
            {
                echo "<p>Erreur : aucun identifiant de commentaire envoyé";
            }
            break;
        default:
            echo ('<p>Erreur 404.</p>');
    }
}
else
{
    echo $twig->render('home.twig');
}
?>