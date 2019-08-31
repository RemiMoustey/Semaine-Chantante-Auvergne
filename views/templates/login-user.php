<?php 
$error = null;
if(!empty($_POST['password']))
{
    if (password_verify($_POST['password'], $adminPassword))
	{
		session_start();
		$_SESSION['authenticatedAdmin'] = 1;
		header('Location: index.php?action=space-users');
	}
	elseif (password_verify($_POST['password'], $password))
	{
		session_start();
		$_SESSION['authenticatedUser'] = 1;
		header('Location: index.php?action=space-users');
    }
	else
	{
		$error = "Mot de passe incorrect";
	}
}

require_once 'auth.php';
if(isAuthenticatedUser())
{
	header('Location: index.php?action=space-users');
}
if(isAuthenticatedAdmin())
{
	header('Location: index.php?action=space-users');
}
?>

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
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control" required />
                <button class="btn btn-primary mt-5" type="submit">Se connecter</button>
            </form>
        </div>
    </body>
</html>