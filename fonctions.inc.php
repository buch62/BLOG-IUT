<?php

function print_r2($ma_varriable) {
    echo '<pre>';
    print_r($ma_varriable); //Affichage du contenue du la variable ma_varriable
    echo '</pre>';

    return true;
}

function declareNotification($message, $result) {
    $_SESSION['notification']['message'] = $message;
    $_SESSION['notification']['result'] = $result;

    return TRUE;
}

Function countArticles($bdd) {
    /* @var $bdd PDO */
    $sth = $bdd->prepare("SELECT COUNT(*) as total "
            . "FROM articles "
            . "WHERE publie = :publie");
    $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}

Function returnindex($page_courante, $nb_articles_par_pages) {
    $index_depart = (($page_courante - 1) * $nb_articles_par_pages);

    return $index_depart;
}
