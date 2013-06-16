<?php

/*
 * Modèle pour les membres
 */

require_once('TableUser.php');

class TableMembre extends TableUser {

    public function modifyInformation($login, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update Membre
            Set prenom = '$prenom', nom = '$nom', email = '$email', telephone = '$tel',
                ecole = '$ecole', annee = '$annee'
            Where login = '$login';";
        mysql_query($query);
    }

    public function modifyPassword($login, $password) {
        $query = "Update Membre
            Set password = PASSWORD('$password')
            Where login = '$login';";
        mysql_query($query);
    }

    public function modifyRights($login, $droits) {
        $query = "Update Membre
            Set droits = '$droits'
            Where login = '$login';";
        mysql_query($query);
    }

}

?>
