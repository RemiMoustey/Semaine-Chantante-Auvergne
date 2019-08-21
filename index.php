<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name=viewport content="width=device-width, initial-scale=1.0" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous" />
        <link href="./public/css/home-page.css" rel="stylesheet" />
        <link href="./public/css/styles.css" rel="stylesheet" />
        <script src="./public/js/Image.js"></script>
        <script src="./public/js/Carousel.js"></script>
    </head>

<?php
require_once 'vendor/autoload.php';

use Semaine_Chantante\Controller;
require_once('controller/RegistrationController.php');

// Routing
$registrationController = new Semaine_Chantante\Controller\RegistrationController();

// Rendu du template
$loader = new Twig_Loader_Filesystem(__DIR__  . '\views\templates');

$twig = new Twig_Environment($loader, [
    'debug' => true,
    'cache' => false
]);

if (isset($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'home':
            echo $twig->render('registration.twig');
            break;
        case 'test':
            echo $twig->render('test.twig');
            break;
        case 'readuser':
            $registrationController->listInformationUsers($_GET['id']);
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
            $registrationController->listRegisteredUsers($_POST['q']);
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
        default:
            echo ('Erreur 404');
    }
}
?>

<body>
    <nav class="navbar-inverse navbar-fixed-top">
        <ul class="nav navbar-nav">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Projet</a></li>
            <li><a href="#">Programme</a></li>
            <li><a href="#">Images & sons</a></li>
            <li><a href="#">En savoir plus</a></li>
            <li><a href="#">Inscriptions</a></li>
        </ul>
    </nav>
    <div id="bloc_page">
        <div id="carousel_item">
            <img src="public/img/1-r.png" alt="Volcans du département du Puy-de-Dôme" class="image-1" />
        </div>
    </div>
</body>