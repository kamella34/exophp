<?php

include "pdo.php";
include "requete.php";

//On vérifie si il y a bien un fichier dans $_FILES
if($_FILES['img']['size'] > 0) {

    $dir = "images/";

    //En stockant $_FILES['img'] dans $file, plus besoin de passer par $_FILES['img']['size'] par exemple,
    //mais directement par $file['size']
    $file = $_FILES['img'];

    //On stock le pseudo vec une majuscule et tout le reste en minuscule
    $pseudo = ucfirst(strtolower($_POST['name']));

    //Ici on vérifie si le pseudo existe déjà et on stock le résultat
    $testPseudo = requete_findUserName($name);

    //On créé notre try qui sera toujours suivi d'un catch
    try {

        //On vérifie si le dossier images/ existe, si non, on le créé
        if (!file_exists($dir)) {
            mkdir($dir,0777);
        }

        //On stock uniquement l'extension dans $extension
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

        //On stock un numéro aléatoire dans $random
        $random = rand(0,99999);

        //On remplace les espaces du nom du fichier par "_"
        $file['name'] = str_replace(" ","_",$file['name']);

        //On créé le chemin du nouveau fichier
        $target_file = $dir.$random."_".$pseudo.".".$extension;

        //Ici on vérifie que nous avons bien une image
        if (!getimagesize($file['tmp_name'])) {
            throw new Exception("erreur");
        }

        //On vérifie si c'est bien un jpg, un jpeg ou un png
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png") {
            throw new Exception("format");
        }

        //Si le pseudo existe déjà on affiche une erreur
        if ($testPseudo) {
            throw new Exception("existe");
        }

        //On vérifie la taille de l'image
        if ($file['size'] > 1000000) {
            throw new Exception("taille");
        }

        //On déplace le fichier uploadé dans notre dossier /images en lui donnant le nom de l'utilisateur
        move_uploaded_file($file['tmp_name'], $target_file);

        //Ici on stock le nouveau nom (comme dans $target_file mais sans le chemin "images/")
        $name = $random."_".$pseudo.".".$extension;

        //On lance notre requête pour ajouter le nouvel utilisateur en base de données et on stock le résultat dans $result
        $result = requete_addUser($_POST['name'],$_POST['mail'],$name);

        //Si $result est false, on envoi une erreur
        if (!$result) {
            throw new Exception("ajout");
        }  

        header("location: index.php?success=ajout");

    //Si il y a eu une erreur et qu'on a donc appelé un "throw new Exception('...')" on effectue ce quy'il y a dans "catch"
    } catch (Exception $e){

        //Ici on redirige sur index.php avec le message d'erreur créé dans "throw new Exception('...')"
        header("location: index.php?errors=".$e->getMessage());
    }

} else {
    header("location: index.php?errors=fichier");
}