<?php
require_once 'Config/int.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'Config/bdd.int.conf.php';
require_once 'Config/connection.conf.php';
include_once 'include/header.inc.php';


/* @var $bdd PDO */

if (isset($_POST['submit'])) {
    print_r2($_POST);
    // exit();


    $email = $_POST['email'];
    $mdp = sha1($_POST['mdp']); //Calcule le sha1 (mot de passe)

    $sth = $bdd->prepare("SELECT * " //preparation requete insertion BDD
            . "FROM utilisateur "
            . "WHERE email = :email AND mdp = :mdp");
    $sth->bindValue(':email', $email, PDO::PARAM_STR);
    $sth->bindValue(':mdp', $mdp, PDO::PARAM_STR);


    $sth->execute(); // execution de la requete 

    if ($sth->rowCount() > 0) {
        // La connexion est ok
        $donnes = $sth->fetch(PDO::FETCH_ASSOC);
        //print_r2($donnes);
        $sid = $donnes['email'] . time();
        $sid_hache = md5($sid);
        //echo $sid_hache;

        setcookie('sid', $sid_hache, time() + 3600);

        $sth_update = $bdd->prepare("UPDATE utilisateur "
                . "SET sid = :sid "
                . "WHERE id = :id");

        $sth_update->bindValue(':sid', $sid_hache, PDO::PARAM_STR);
        $sth_update->bindValue(':id', $donnes['id'], PDO::PARAM_INT);

        $result_connexion = $sth_update->execute();
        //var_dump($sth_update);
// Notifications
        if ($result_connexion == TRUE) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = '<b>Félicitation</b>';
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = '<b> Attention!</b>';
        }


        header("Location: index.php"); //Redirection vers l'accueil

        exit();
    } else {
        //La connexion est refusée
        //notification
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = '<b> Attention!</b>';
        header("Location: index.php");

        exit();
    }
}
// fabien.flahaut@hotmail.fr
//12345678
?>




<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Connection utilisateur</h1>
            <h2>Se Connecter</h2>
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form method="post" action="connection.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Mail</label>
                    <input type="email" class="form-control" id="email" placeholder="email" name="email" require>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control-file" id="mdp" name="mdp" required>

                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="bouton">Envoyer</button>
            </form>
        </div>
    </div>