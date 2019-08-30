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

    <?php require('template-login.php') ?>
        <div class="form-login w-50 m-auto">
            <h2>Connexion</h2>
            <?php
            if (isset($error) AND $error)
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