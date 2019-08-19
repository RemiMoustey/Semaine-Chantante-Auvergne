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
        <?php $data = $infos->fetchAll();
        $info = $data[0];
        ?>
        <h3>Informations sur <?= $info['firstname'] . " " . $info['username'] ?></h3>
        <p class="bold">
                <?php
                if ($info['status'] === 'Choriste')
                {
                    echo "Choriste";
                }
                elseif ($info['status'] === 'Chef de choeur')
                {
                    echo "Chef de Choeur";
                }
                ?>
                <?php
                echo " - ";
                switch ($info['music_stand'])
                {
                    case 'Soprane':
                        echo "Soprane";
                        break;
                    case 'Alto':
                        echo "Alto";
                        break;
                    case 'Tenor':
                        echo "Ténor";
                        break;
                    case 'Basse':
                        echo "Basse";
                        break;
                }
                ?>
            </p>
        <form method="post" action="index.php?action=adduser">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $info['username'] ?>" required />
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $info['firstname'] ?>" required />
            <label for="address">Adresse</label>
            <input type="text" name="address" id="address" class="form-control" value="<?= $info['user_address'] ?>" required />
            <label for="postal_code">Code postal</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" value="<?= $info['postal_code'] ?>" required />
            <label for="town">Ville</label>
            <input type="text" name="town" id="town" class="form-control" value="<?= $info['town'] ?>" required />
            <label for="phone_number">Téléphone</label>
            <input type="tel" name="phone_number" id="phone_number" class="form-control" value="<?= $info['phone_number'] ?>" required />
            <label for="phone_number_office">Téléphone Bureau</label>
            <input type="tel" name="phone_number_office" id="phone_number_office" class="form-control" value="<?= $info['phone_number_office'] ?>" />
            <label for="email">Courriel</label>
            <input type="text" name="email" id="email" class="form-control" value="<?= $info['email'] ?>" required />
            <label for="birthday">Date de naissance</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="<?= $info['birthday'] ?>" required />
            <label for="choir_name">Nom de la chorale</label>
            <input type="text" name="choir_name" id="choir_name" value="<?= $info['choir_name'] ?>" class="form-control" required />
            <label for="choir_town">Ville de la chorale</label>
            <input type="text" name="choir_town" id="choir_town" value="<?= $info['choir_town'] ?>" class="form-control" required />
            <p class="bold payment">Mode de versement : <?= $info["payment"] ?></p>
            <label for="additional">Complément d'information</label>
            <p><?= $info['additional'] ?></p>
        </form>
        <p>
            <a href="index.php?action=acceptuser&amp;username=<?= $info['username'] ?>">Accepter</a>
        </p>
    </body>
</html>