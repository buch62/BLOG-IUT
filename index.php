<?php
require_once 'Config/int.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'Config/bdd.int.conf.php';
require_once 'Config/connection.conf.php';
include_once 'include/header.inc.php';

/* @var $bdd PDO */

//print_r2($_SESSION);
//print_r2($_GET);

$page_courante = !empty($_GET['p']) ? $_GET['p'] : 1;

$nb_total_articles = countArticles($bdd);
//var_dump($nb_total_articles);

$index_depart = returnIndex($page_courante, _nb_articles_par_page_);
//var_dump($index_depart);

$nb_total_pages = ($nb_total_articles / _nb_articles_par_page_);
//var_dump($nb_total_pages);


$sth = $bdd->prepare("SELECT id, " //preparation requete 
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
        . "publie "
        . "FROM articles "
        . "WHERE publie = :publie "
        . "LIMIT :index_depart, :nb_articles_par_page ");


$sth->bindValue("publie", 1, PDO::PARAM_BOOL); //fonction PDO qui sécurise le paramètre avant d'exécuter la requête
$sth->bindValue("index_depart", $index_depart, PDO::PARAM_INT);
$sth->bindValue(":nb_articles_par_page", _nb_articles_par_page_, PDO::PARAM_INT);
$sth->execute(); //executionde la requête 

$tab_result = $sth->fetchAll(PDO::FETCH_ASSOC); //Retourne tableau avec toutes les lignes du jeu d'enregistrements
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Bonjour et bienvenue!</h1>
            <p class="lead">Les articles publié son ci dessous.</p>
            <ul class="list-unstyled">
                <li>*******</li>
                <li>*****</li>
            </ul>
        </div>
    </div>
    <?php
    if (isset($_SESSION['notification'])) {
        ?>
        <div class="row">
            <div class ="col-12">
                <div class="alert alert-<?= $_SESSION['notification']['result'] ?>" role="alert">
                    <?= $_SESSION['notification']['message'] ?>
                    <?php unset($_SESSION['notification']) ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <?php
            foreach ($tab_result as $key => $value) {
                ?>
                <div class="col-6">   
                    <div class="card" style="width: 100%;">
                        <img src="img/<?= $value['id']; ?>.jpg" class="card-img-top" alt="<?= $value['titre']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $value["titre"]; ?>Titre</h5>
                            <p class="card-text"><?= $value["titre"]; ?>Bla Bla Bla.</p>
                            <a href="#" class="btn btn-primary"><?= $value["date_fr"]; ?></a>
                            <a href="article.php?id=<?= $value['id']; ?> &action=modifier" class="btn btn-primary">Modifier</a>
                        </div>
                    </div> 
                </div>
                <?php
            }
            ?>
        </div>
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="pagination pagination-lg">
                        <?php
                        for ($index = 1; $index <= $nb_total_pages; $index++) {
                            $active = $page_courante == $index ? 'active' : '';
                            ?>
                            <li class="page-item <?= $active ?>"><a class="page-link" href="?p=<?= $index ?>" ><?= $index ?></a></li>
                                <?php
                            }
                            ?>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.slim.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        </body>

        </html>
