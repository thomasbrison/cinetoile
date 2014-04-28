<?php

// Connexion à la BD
function connexion_bd() {
    /* Connexion à une base ODBC avec l'invocation de pilote */
    $dsn = 'mysql:host=localhost;port=3306;dbname=cinetoile;charset=utf8';
    $user = 'Cinetoile';
    $password = 'tarantino';

    try {
        $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion &agrave; la base de donn&eacute;es &eacute;chou&eacute;e : ' . $e->getMessage();
    }
    return $dbh;
}

?>
