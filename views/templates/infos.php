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
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    </head>

    <body>
        <div class="container-fluid">
        <?php
        
        $data = $infos->fetchAll();
        if (!empty($data))
        {
            $info = $data[0];
            $isAccepted = false;
            foreach ($acceptedUsers as $acceptedUser)
            {
                if (in_array($info['id'], $acceptedUser))
                {
                    $isAccepted = true;
                }
            }
            ?>
            <h1 class="green-title title-page text-center">Informations sur <?= $info['firstname'] . " " . $info['surname'] ?></h1>
            <div class="bloc-form col-6 m-auto">
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
                    $printedText = $isAccepted ? ' - <span class="green">Inscription réglée par ' : '<br /><span class="red">Règlement en attente par ';
                    $printedText .= htmlspecialchars($info["payment"]) . "</span>";
                    echo $printedText;
                    ?>
                </p>
                <form method="post" action="index.php?action=updateuser&amp;id=<?= $info['id'] ?>">
                    <div class="form-group">
                        <label for="surname">Nom</label>
                        <input type="text" name="surname" id="surname" class="form-control" value="<?= htmlspecialchars($info['surname']) ?>" required />
                        <span id="miss-surname"></span>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="<?= htmlspecialchars($info['firstname']) ?>" required />
                        <span id="miss-firstname"></span>
                    </div>
                    <div class="form-group">
                        <label for="user_address">Adresse</label>
                        <input type="text" name="user_address" id="user_address" class="form-control" value="<?= htmlspecialchars($info['user_address']) ?>" required />
                        <span id="miss-user_address"></span>
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Code postal</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" value="<?= htmlspecialchars($info['postal_code']) ?>" required />
                        <span id="miss-postal_code"></span>
                    </div>
                    <div class="form-group">
                        <label for="town">Ville</label>
                        <input type="text" name="town" id="town" class="form-control" value="<?= htmlspecialchars($info['town']) ?>" required />
                        <span id="miss-town"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Téléphone</label>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control" value="<?= htmlspecialchars($info['phone_number']) ?>" required />
                        <span id="miss-phone_number"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone_number_office">Téléphone Bureau</label>
                        <input type="tel" name="phone_number_office" id="phone_number_office" class="form-control" value="<?= htmlspecialchars($info['phone_number_office']) ?>" />
                        <span id="miss-phone_number_office"></span>
                    </div>
                    <div class="form-group">  
                        <label for="email">Courriel</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($info['email']) ?>" required />
                        <span id="miss-email"></span>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Date de naissance</label>
                        <input type="date" name="birthday" id="birthday" class="form-control" value="<?= htmlspecialchars($info['birthday']) ?>" required />
                        <span id="miss-birthday"></span>
                    </div>
                    <div class="form-group">
                        <label for="choir_name">Nom de la chorale</label>
                        <input type="text" name="choir_name" id="choir_name" value="<?= htmlspecialchars($info['choir_name']) ?>" class="form-control" required />
                        <span id="miss-choir_name"></span>
                    </div>
                    <div class="form-group">
                        <label for="choir_town">Ville de la chorale</label>
                        <input type="text" name="choir_town" id="choir_town" value="<?= htmlspecialchars($info['choir_town']) ?>" class="form-control" required />
                        <span id="miss-choir_town"></span>
                    </div>
                    <p class="text-justify"><label for="additional">Complément d'information</label><br />
                        <?= htmlspecialchars($info['additional']) ?></p>
                    <p><input type="submit" value="Modifier" id="submit" class="formular-button"></p>
                </form>
                <p>
                <?php
                if (!$isAccepted)
                {
                ?>
                    <button href="index.php?action=acceptuser&amp;id=<?= $info['id'] ?>" class="green accept formular-button" onclick="return(confirm('Êtes-vous sûr de vouloir accepter le règlement ?'));">Valider le règlement</button>
                <?php
                }
                else
                {
                ?>
                    <button href="index.php?action=deleteaccepteduser&amp;id=<?= $info['id'] ?>" class="cancel formular-button" onclick="return(confirm('Êtes-vous sûr de vouloir annuler le règlement ?'));">Annuler le règlement</button>
                <?php
                }
                ?>
                <button href="index.php?action=deleteregistereduser&amp;id=<?= $info['id'] ?>" class="delete formular-button" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?'));">Supprimer l'inscription</button>
            <?php
            }
            else
            {
                echo "<p>Erreur : Utilisateur introuvable</p>";
            }
            ?>
        </div>
        <script src="./public/js/test-formular.js"></script>
    </body>
</html>