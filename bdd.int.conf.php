<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');    //connexion a la bdd
    $bdd->exec('set names utf8');    //encodage utf8 
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    //Configuration rapport erreur exceptions
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}