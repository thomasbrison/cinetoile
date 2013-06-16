<?php

/*
 * Modèle pour les membres
 */

require_once('TableUser.php');
require_once(dirname(__FILE__) . '/../Beans/Membre.class.php');

class TableMembre extends TableUser {

    public function modifyInformation(Membre $membre) {
        $login = $membre->getLogin();
        $prenom = $membre->getPrenom();
        $nom = $membre->getNom();
        $email = $membre->getEmail();
        $tel = $membre->getTelephone();
        $ecole = $membre->getEcole();
        $annee = $membre->getAnnee();
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
