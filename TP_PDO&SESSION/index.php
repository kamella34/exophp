<?php
        session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>TP PDO</title>
</head>

<body>

    <?php
    
    // Si l'utilisateur n'est pas connecté, il est redirigé vers connexion.php
    if (empty($_SESSION['user'])) {
        header('location: connexion.php');
    }

    include "pdo.php";
    include "requete.php";

    //Je stock tout les utilisateurs enregistrés en BdD dans une variable
    $allData = requete_lire_all_user();

    ?>

    <section class="container mt-5">
        <div class="row">
            <div class="col-6">

                <!-- Un magnifique formulaire avec, un input et un bouton, qui utilise la méthode GET -->
                <form action="#" method="GET">
                    <label for="pseudo">Entrez un nom :</label>
                    <input type="text" id="pseudo" name="pseudo">
                    <button class="btn btn-primary">ENVOYER</button>
                </form>
            </div>
            <div class="col-6">
                <h2>Qui voulez-vous voir ?</h2>
                <ul>
                <?php 

                    // J'affiche tout les pseudos des utilisateurs grace à un foreach de $allData qui contient tout nos utilisateurs
                    foreach($allData as $value) {
                        echo "<li>" . $value['pseudo'] . " ?</li>";
                    }
                ?>
                </ul>

            </div>


            <?php

            // Je vérifie si $_GET['pseudo'] est initialisée, car le formulaire utilise la méthode GET
            if (isset($_GET['pseudo'])) {

                // On récupère les infos de l'utilisateur en BdD, l'utilisateur saisi via le formulaire, et on les stock dans une variable
                $data = requete_findUser($_GET['pseudo']);

                // Si l'utilisateur existe...
                if ($data) {

                    // On affiche ses informations stockées dans $data
                    echo "<p>Bonjour " . ucfirst($data['pseudo']) . ", votre mail est : " . $data['mail'] . "</p>";

                    // Si $_GET['pseudo'] est vide...
                } else if (empty($_GET['pseudo'])){

                    // J'affiche un message d'erreur
                    echo "<p>Veuillez remplir le champ !</p>";

                    // Si l'utilisateur n'existe pas...
                } else {

                    // J'affiche un autre message d'erreur
                    echo "<p>Tu vois bien que je ne suis pas dans la liste !</p>";
                }

            // Tant que $_GET['pseudo'] n'existe pas... 
            } else {

                // J'affiche un message par défaut
                echo "<p>Il y a quelqu'un ?</p>";
            }
            ?>
        </div>
    </section>

    <center>
        <form action="deconnexion.php">

            <!-- Un bouton qui envoie sur déconnexion.php pour se déconnecter -->
            <button class="btn btn-primary">DECONNEXION</button>

        </form>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>