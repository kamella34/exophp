<?php

// fonction qui créée une nouvelle instance de PDO
function connexion_BD()
{
        $db = new PDO("mysql:host=localhost;dbname=tp_pdo_session;charset=utf8", "root", "");
        return $db;
}