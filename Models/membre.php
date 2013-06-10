<?php

/*
 * Modèle pour les membres
 */

require_once('user.php');

class Membre extends User {

    public function modifyInformation($login, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update Membre
                      Set prenom='$prenom', nom='$nom', email='$email', telephone='$tel', ecole='$ecole', annee='$annee'
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifyPassword($login, $password) {
        $query = "Update Membre
                      Set password=PASSWORD('$password')
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifyRights($login, $droits) {
        $query = "update Membre
                      set droits='$droits'
                      where login = '$login';";
        mysql_query($query);
    }

}

?>
