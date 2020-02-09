<?php
require_once 'Config/int.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'Config/bdd.int.conf.php';
require_once 'Config/connection.conf.php';
include_once 'include/header.inc.php';

if (iset($_GET['recherche'])) {
    /* @var $bdd PDO */
    //echo $_GET['recherche'];

    $page_courante = !empty($_GET['p']) ? $_GET['p'] : 1;


    $nb_total_article = countArticle($bdd);


    $index_depart = returnIndex($page_courante, _nb_article_par_page_);


    $nb_total_pages = ceil($nb_total_article / _nb_article_par_page_);


    $select_article = "SELECT "
            . "id, "
            . "titre, "
            . "texte, "
            . "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
            . "publie "
            . "FROM article "
            . "WHERE publie = :publie "
            . "AND (titre LIKE :recherche OR texte LIKE :recherche) "
            . "LIMIT :index_depart, :nb_article_par_page";

    $sth = $bdd->prepare($select_article);
    $sth->bindValue(":publie", 1, PDO::PARAM_BOOL); //fonction pdo qui permet de sécuriser le paramètre avant d'exécuter la requête
    $sth->bindValue(":index_depart", $index_depart, PDO::PARAM_INT);
    $sth->bindValue(":nb_article_par_page", _nb_article_par_page_, PDO::PARAM_INT);
    $sth->bindValue(":recherche", '%' . $_GET['recherche'] . '%', PDO::PARAM_STR);
    $sth->execute(); //on exécute la requête préparée juste avant

    $tab_result = $sth->fetchAll(PDO::FETCH_ASSOC);

//print_r2($tab_result);
}
?> 

<?php if (!empty($_GET['recherche'])) { ?>

    <?php
    foreach ($tab_result as $cle => $valeur) {
        ?> 
        <div class="col-6">
            <div class="card" style="width: 100%;"> 
                <img src="img/<?= $valeur['id']; ?>.jpg" class="card-img-top" alt="<?= $valeur['titre']; ?>">
                <div class="card-body"> 
                    <h5 class="card-title"><?= $valeur['titre'] ?></h5>
                    <p class="card-text"><?= $valeur['texte'] ?></p>
                    <a href="#" class="btn btn-primary"><?= $valeur['date_fr'] ?></a>
                    <a href="article.php?id=<?= $valeur['id'] ?>&action=modifier" class="btn btn-primary">Modifier</a>
                </div>  
            </div> 
        </div> 
        <?php
    }
}?>