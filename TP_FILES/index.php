<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>TP_FILES</title>
</head>

<body>

    <?php

    // Nos 2 includes nous permettent d'utiliser les fonctions sur pdo.php et requete.php
    include "pdo.php";
    include "requete.php"; 

    //On vérifie si $_GET['id] est initialisé...
    if (isset($_GET['id'])) {

        //On stock dans $user les informations de l'utilisateur lié à l'id dans $_GET['id']
        $user = requete_findUser($_GET['id']);

        //On stock le nom de l'image lié à l'utilisateur
        $currentImg = $user->users_img;

        //On supprime l'image dans notre dossier images/ à l'aide de la fonction php unlink()
        unlink("images/" . $currentImg);

        //On supprime l'utilisateur en question
        requete_deleteUser($_GET['id']);

        //Puis on redirige vers index.php, et on fait passer "suppr" dans un GET : $_GET['success']
        header("location: index.php?success=suppr");
    }

    //On stock tout les utilisateurs en BdD dans $users
    $users = requete_displayUsers();
    ?>

    <!-- Un magnifique h1... -->
    <h1 class="text-center my-5">TP FILES</h1>

    <div class="container mb-5">

        <!-- Un formulaire avec 2 inputs de type text et un de type file
             On pense bien à mettre la destination dans action="", la method POST ou GET
             Et enctype="multipart/form-data" pour pouvoir upload un fichier dans l'input file et créer $_FILES à l'envoi -->
        <form action="traitement_ajout_user.php" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label for="name" class="input-group-text">Nom :</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label for="mail" class="input-group-text">Adresse mail :</label>
                <input type="text" name="mail" id="mail" class="form-control">
            </div>

            <div class="input-group mb-3">
                <input type="file" name="img" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            </div>

            <div class="input-group mb-3">
                <button class="btn btn-dark">ENVOYER</button>
            </div>
        </form>

    </div> 

    <?php

    //On vérifie si $_GEt['errors'] est bien initialisé...
    if (isset($_GET['errors'])) {
    ?>
        <!-- Si c'est le cas, j'affiche une div -->
        <div class="container alert alert-danger text-center">
            <?php

            //Et dans cette div, j'affiche un message d'erreur en fonction du contenu de $_GET['errors']
            if ($_GET['errors'] === "existe")
                echo "L'utilisateur que vous souhaitez ajouter, est déjà inscrit";

            else if ($_GET['errors'] === "taille")
                echo "La taille de l'image dépasse 100 Ko";

            else if ($_GET['errors'] === "format")
                echo "Votre image doit être un jpg, jpeg ou png";

            else if ($_GET['errors'] === "erreur")
                echo "Le fichier uploadé n'est pas une image";

            else if ($_GET['errors'] === "ajout")
                echo "Une erreur est survenue lors de l'envoie du formulaire";

            else if ($_GET['errors'] === "fichier")
                echo "Veuillez choisir une image";
            ?>
        </div>
    <?php

    //Même chose, je vérifie si $_GET['success'] est bien initialisé...
    } else if (isset($_GET['success'])) {
    ?>
        <!-- Si oui, j'affiche une div -->
        <div class="container alert alert-success text-center">
        <?php
        
        //Et en fonction du contenu de $_GET['success'], j'affiche un message
        if ($_GET['success'] === "ajout") {
            echo "Ajout effectuée";
        } else if ($_GET['success'] === "modif") {
            echo "Modification effectuée";
        } else if ($_GET['success'] === "suppr") {
            echo "Suppression effectuée";
        }
    }
        ?>
        </div>

        <div class="container">

            <?php

            //Ce foreach parcours le tableau $users qui contient tout nos utilisateurs spus forme d'objet
            //Et pour chaque ligne de ce tableau, il stock la valeur dans $value ($value existera seulement dans ce foreach)
            //Et effectue toutes les instructions entre les accolades pour chaque ligne du tableau
            foreach ($users as $value) {
            ?>
                <!-- Toute cette partie html s'affiche alors pour chaque ligne du tableau $users -->
                <div class="card mx-auto mb-3" style="width: 18rem;">
                    <img src="images/<?= htmlspecialchars($value->users_img) ?>" class="card-img-top" alt="..." style="object-fit: cover; height: 250px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($value["users_name"]) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($value->users_mail) ?></p>
                        <a href="index.php?id=<?= $value->id_users ?>" class="btn btn-outline-dark">SUPPRIMER</a>
                        <a href="modifier.php?name=<?= $value->users_name ?>&mail=<?= $value->users_mail ?>&img=<?= $value->users_img ?>&id=<?= $value->id_users ?>" class="btn btn-outline-dark">MODIFIER</a>
                    </div>
                </div>

            <?php
            }

            ?>

        </div>

        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <!-- Un bouton un peu inutile qui renvoie en haut de la page ! :D -->
            <a href="#" class="btn btn-dark">RETOUR HAUT</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>