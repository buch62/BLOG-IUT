<?php
require_once 'Config/int.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'Config/bdd.int.conf.php';
require_once 'Config/connection.conf.php';
include_once 'include/header.inc.php';


/* @var $bdd PDO */

if (!empty($_POST['submit'])) {
    // print_r2($_POST);



    $email = $_POST['email'];
    $mdp = sha1($_POST['mdp']); //cryptage du mot de passe
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];



    $sth = $bdd->prepare("INSERT INTO utilisateur " //preparation de la requete 
            . "(email, mdp, nom, prenom) "
            . "VALUES (:email, :mdp, :nom, :prenom)");
    $sth->bindValue("email", $email, PDO::PARAM_STR);
    $sth->bindValue("mdp", $mdp, PDO::PARAM_STR);
    $sth->bindValue("nom", $nom, PDO::PARAM_STR);
    $sth->bindValue("prenom", $prenom, PDO::PARAM_STR);

    $sth->execute(); //execution de la requete 

    $id_utilisateur = $bdd->lastInsertId();




    //notification
    $message = '<b>Félicitation</b> votre <u>utilisateur</u> est ajouté!'; //notification si bien ajouté
    $result = 'success';

    declareNotification($message, $result);

    header("location: index.php"); //redirection a la page d'accueil
    exit();
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Ajouter un utilisateur</h1>
            <br>
            <div class="row">
                <div class="col-12">
                    <form method="post" action="utilisateur.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="email">Mail</label>
                            <input type="email" class="form-control" id="email" placeholder="email" name="email" require>
                        </div>
                        <div class="form-group">
                            <label for="mdp">Mot de passe</label>
                            <input type="password" class="form-control-file" id="mdp" name="mdp" required>
                        </div>  
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control-file" id="nom" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control-file" id="prenom" name="prenom" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="bouton">Envoyer</button>
                    </form>


                </div>
            </div>


            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.slim.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            </body>

            </html>