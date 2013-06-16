<?php

// Connexion à la BD
function connexion_bd() {
    $connect = mysql_connect('localhost', utf8_decode('Cinétoile'), 'tarantino');
    if (!$connect) {
        die("Erreur de connexion au serveur");
    }
    mysql_select_db('cinetoile') or
            die("Erreur de connexion &agrave; la base de donn&eacute;es");
    define('connect', $connect);
}

?>
