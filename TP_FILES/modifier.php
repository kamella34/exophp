<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Modifier</title>
</head>

<body>
    <?php
    include "pdo.php";
    include "requete.php";

    //Si $_GET esy vide, redirige vers index.php
    if (empty($_GET)) {
        header("location: index.php");
    }
    ?>

    <h1 class="text-center my-5"><?= htmlspecialchars($_GET['name']) ?></h1>

    <div class="container mb-5">

        <!-- Formulaire de modification avec des inputs préremplis à l'aide de l'attribut html value="" -->
        <form action="traitement_modifier.php" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label for="name" class="input-group-text">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" value="<?=htmlspecialchars($_GET['name'])?>">
            </div>

            <div class="input-group mb-3">
                <label for="mail" class="input-group-text">Adresse mail :</label>
                <input type="text" name="mail" id="mail" class="form-control" value="<?=htmlspecialchars($_GET['mail'])?>">
            </div>

            <div class="input-group mb-3">
                <input type="file" name="img" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            </div>

            <div class="d-none input-group mb-3">
                <input type="text" class="form-control" name="img" value="<?=htmlspecialchars($_GET['img'])?>">
            </div>

            <div class="d-none input-group mb-3">
                <input type="text" class="form-control" name="id" value="<?=$_GET['id']?>">
            </div>

            <div class="input-group mb-3">
                <button class="btn btn-dark">MODIFIER</button>
            </div>
        </form>

        <!-- Ici un simple bouton qui renvoie sur notre page d'accueil -->
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <a href="index.php" class="btn btn-dark">RETOUR ACCUEIL</a>
        </div>

    </div>

</body>

</html>