<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name=viewport content="width=device-width, initial-scale=1.0" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous" />
        <link href="./public/css/styles.css" rel="stylesheet" />
        <link href="./public/css/home-page.css" rel="stylesheet" />
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm fixed-top bg-dark">
            <a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a data-target="#" href="?action=home" class="nav-link">Accueil</a>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Projet</a>
                        <div class="dropdown-menu project">
                            <a class="dropdown-item" href="#">Équipe d'animation</a>
                            <a class="dropdown-item" href="#">Hébergement</a>
                            <a class="dropdown-item" href="#">Objectifs</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Programme</a>
                        <div class="dropdown-menu program">
                            <ul>
                                <li><a class="dropdown-item" href="#">Chant commun</a></li>
                                <li><a class="dropdown-item" href="#">Mise en scène</a></li>
                                <li><a class="dropdown-item" href="#">Temps libre</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Images & sons</a>
                        <div class="dropdown-menu images_sounds">
                            <ul>
                                <li><a class="dropdown-item" href="#">Photos</a></li>
                                <li><a class="dropdown-item" href="#">Chansons</a></li>
                                <li><a class="dropdown-item" href="#">Vidéos</a></li>
                                <li><a class="dropdown-item" href="./index.php?action=newspaper">Presse</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">En savoir plus</a>
                        <div class="dropdown-menu infos">
                            <ul>
                                <li><a class="dropdown-item" href="#">Questions Réponses</a></li>
                                <li><a class="dropdown-item" href="#">Infos pratiques</a></li>
                                <li><a class="dropdown-item" href="#">Contact</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Membres</a>
                        <div class="dropdown-menu inscriptions">
                            <ul>
                                <li><a class="dropdown-item" href="#">Espace inscrits</a></li>
                                <li><a class="dropdown-item" href="#">Administrateur</a></li>
                                <li><a class="dropdown-item" href="#">S'inscrire</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
       
    </body>
</html>