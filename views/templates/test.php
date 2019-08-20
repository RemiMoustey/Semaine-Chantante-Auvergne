<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous" />
        <link href="./public/css/styles.css" rel="stylesheet" />
    </head>

    <body>
        <p>
            <form method="post" action="index.php?action=listusers">
                Rechercher : <input type="text" name="q" required />
                <input type="submit" value="Rechercher" />
            </form>
        </p>
        </p>
            <a href="index.php?action=export">Exporter les données</a>
        <p>
        <?php

        while ($data = $users->fetch())
        {
        ?>
        <p>
        <?php
            echo strtoupper($data['surname']) . " " . $data['firstname'];
        ?>
            <a href="index.php?action=readuser&amp;id=<?= $data['id'] ?>">Lire</a>
        </p>
        <?php
        }
        ?>
    </body>
</html>