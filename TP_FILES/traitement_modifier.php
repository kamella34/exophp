<?php

include "pdo.php";
include "requete.php";

//Si on modifie l'image...
if($_FILES['img']['size'] > 0) {

    //On commence par refaire le même traitement d'image qu'à l'ajout
    $dir = "images/";
    $file = $_FILES['img'];

    try {

        if (!file_exists($dir)) {
            mkdir($dir,0777);
        }

        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

        $random = rand(0,99999);

        $pseudo = ucfirst(strtolower($_POST['name']));

        $target_file = $dir.$random."_".$pseudo.".".$extension;

        if (!getimagesize($file['tmp_name'])) {
            throw new Exception("erreur");
        }
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png") {
            throw new Exception("format");
        }
        if (file_exists($target_file)) {
            throw new Exception("existe");
        }
        if ($file['size'] > 1000000) {
            throw new Exception("taille");
        }

        //Si aucune erreur, on commence par récupérer le nom de l'image déjà existante en base de données
        $user = requete_findUser($_POST['id']);
        $currentImg = $user->users_img;

        //On supprime cette image de notre dossier images/
        unlink("images/" . $currentImg);

        //On déplace la nouvelle image dans images/
        move_uploaded_file($file['tmp_name'], $target_file);

        //Puis on lance la requête de modification avec le nom de la nouvelle image et les POST du formulaire
        $nameImg = $random."_".$pseudo.".".$extension;
        $result = requete_modify($_POST['name'],$_POST['mail'],$nameImg,$_POST['id']);
        if (!$result) {
            throw new Exception("ajout");
        }

        header("location: index.php?success=modif");

    } catch (Exception $e){
        header("location: index.php?errors=".$e->getMessage());
    }

//Si on ne modifie pas l'image...
} else if ($_FILES['img']['size'] === 0) {

    //Ici on sépare le nom de l'image et son extension et on les stock dans le tableau $newImg
    $newImg = explode(".",$_POST['img']);

    //On sépare le numéro aléatoire et le nom de l'image pour pouvoir réutiliser le même numéro
    $oldRand = explode("_",$newImg[0]);

    //On créé le nouveau nom d'image avec le même numéro
    $newTrueImg = $oldRand[0]."_".$_POST['name'].".".$newImg[1];

    //On récupère le nom de l'image existante, et dans $currentImg on stock le chemin de l'image actuelle dans images/
    $user = requete_findUser($_POST['id']);
    $currentImg = "images/".$user->users_img;

    //On créé le nouveau chemin de la nouvelle image
    $target = "images/".$newTrueImg;

    //On renome l'ancienne image par la nouvelle
    rename("images/".$user->users_img, $target);

    //On lance la requête pour modifier 
    requete_modify($_POST['name'], $_POST['mail'],$newTrueImg,$_POST['id']);

    header("location: index.php?success=modif");
    

} else {

    header("location: index.php?errors=" . $e->getMessage());

}
