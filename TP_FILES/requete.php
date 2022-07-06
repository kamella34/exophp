<?php

function requete_displayUsers() {
    $db = connexion_BD();
    $sql = "SELECT * FROM users ORDER BY users_name";
    $req = $db->prepare($sql);
    $req->execute([]);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function requete_deleteUser($id) {
    $db = connexion_BD();
    $sql = "DELETE FROM users WHERE id_users = :id";
    $req = $db->prepare($sql);
    $req->execute([
        ":id" => $id
    ]);
}

function requete_findUser($id) {
    $db = connexion_BD();
    $sql = "SELECT * FROM users WHERE id_users = :id";
    $req = $db->prepare($sql);
    $req->execute([
        ":id" => $id
    ]);
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data;
}

function requete_findUserName($name) {
    $db = connexion_BD();
    $sql = "SELECT users_name FROM users WHERE users_name = :name";
    $req = $db->prepare($sql);
    $req->execute([
        ":name" => $name
    ]);
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data;
}

function requete_addUser($name, $mail, $img) {
    $db = connexion_BD();
    $sql = "INSERT INTO users (users_name, users_mail, users_img) VALUES (:name, :mail, :img)";
    $req = $db->prepare($sql);
    $result = $req->execute([
        ":name" => $name,
        ":mail" => $mail,
        ":img" => $img
    ]);
    return $result;
}

function requete_modify($name, $mail, $img, $id) {
    $db = connexion_BD();
    $sql = "UPDATE users SET users_name = :name, users_mail = :mail, users_img = :img WHERE id_users = :id";
    $req = $db->prepare($sql);
    $result = $req->execute([
        ":name" => $name,
        ":mail" => $mail,
        ":img" => $img,
        ":id" => $id
    ]);
    return $result;
}

