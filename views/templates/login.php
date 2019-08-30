<?php $error = null;
if(!empty($_POST['login']) AND !empty($_POST['password']))
{
	if ($_POST['login'] === $logs['login'] AND (password_verify($_POST['password'], $logs['hashed_password'])))
	{
		session_start();
		$_SESSION['authenticatedAdmin'] = 1;
		header('Location: index.php?action=search');
	}
	else
	{
		$error = "Identifiants incorrects";
	}
}

require_once 'auth.php';
if(isAuthenticatedAdmin())
{
	header('Location: index.php?action=search');
}
?>
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
    <?php require('template-login.php') ?>
        <div class="form-login w-50 m-auto">
            <h2>Connexion</h2>
            <?php
            if ($error)
            {
            ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
            <?php
            }
            ?>
            <form method="post" action="#">
                <label for="login">Login :</label>
                <input type="text" name="login" id="login" class="form-control" required />
                <br />
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control" required />
                <button class="btn btn-primary mt-5" type="submit">Se connecter</button>
            </form>
        </div>
    </body>
</html>