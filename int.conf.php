<?php

session_start();  //Démarrage de la session
//Affichage des erreurs et avertissements PHP
error_reporting(E_ALL); //Nivaeu de rapport d'ereurs PHP
ini_set("display_errors", 1);

define('_nb_articles_par_page_', 2); //definition de la constante = a 2




date_default_timezone_set('Europe/Paris'); //def du fuseau horair utilisé dans les pages web
