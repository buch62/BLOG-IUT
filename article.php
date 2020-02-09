<?php
require_once 'Config/int.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'Config/bdd.int.conf.php';
require_once 'Config/connection.conf.php';
include_once 'include/header.inc.php';


/* @var $bdd PDO */
$tab_result = array
    ("titre" => "",
    "texte" => "",
    "date_fr" => "",
    "publie" => "",);

if (!empty($_GET['action']) AND $_GET['action'] == 'modifier') {

    $sth = $bdd->prepare("SELECT "
            . "titre, "
            . "texte, "
            . "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
            . "publie "
            . "FROM articles "
            . "WHERE id = :id");
}


$sth->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
$sth->execute();

$tab_result = $sth->fetch(PDO::FETCH_ASSOC);
print_r2($tab_result);

if (!empty($_POST['submit'])) {
    // print_r2($_POST);
    //print_r2($_FILES);

    $titre = $_POST['titre'];
    $texte = $_POST ['texte'];

    $publie = isset($_POST['publie']) ? 1 : 0; //condition ternaire: checkbox coché alors publie prend la valeur 1, sinon 0

    $date = date('Y-m-d'); //Date au format ameraicain (ANNEE-MOIS-JOUR)
    //echo $date;

    $sth = $bdd->prepare("INSERT INTO articles " //Requete modif article dans BDD
            . "(titre, texte, publie, date ) "
            . "VALUES(:titre, :texte, :publie, :date)");
    $sth->bindValue(':titre', $titre, PDO::PARAM_STR);
    $sth->bindValue(':texte', $texte, PDO::PARAM_STR);
    $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
    $sth->bindValue(':date', $date, PDO::PARAM_STR);

    $sth->execute(); //execution de la requete 

    $id_article = $bdd->lastInsertId(); //insertion du dernier id dans la bdd

    if ($_FILES['img']['error'] == 0) {
        move_uploaded_file($_FILES['img']['tmp_name'], 'img/' . $id_article . '.jpg');
    }
    //notification
    $message = '<b>Félicitation</b> votre <u>article</u> est ajouté!'; //message nousdisant que l'article est bien ajouté
    $result = 'success';

    declareNotification($message, $result);

    header("location: index.php"); //redirecetion vers l'acceuill quand article est inseré
    exit();
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Ajouter un article</h1>
            <div class="row">
                <div class="col-12">
                    <form method="post" action="article.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titre">Le titre</label>
                            <input type="text" class="form-control" id="titre" placeholder="titre" name="titre">
                        </div>
                        <div class="form-group">
                            <label for="text">Contenue de l'article</label>
                            <textarea class="form-control" id="texte" rows="3" name="texte"></textarea>
                        </div>  
                        <div class="form-group">
                            <label for="img">l'image de mon article</label>
                            <input type="file" class="form-control-file" id="img" name="img">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="publie" name="publie">
                            <label class="form-check-label" for="publie">Article publié ?</label>
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