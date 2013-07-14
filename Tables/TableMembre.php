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
        $sth = $this->dbh->query($query);
        $sth->execute();
    }

    public function modifyPassword($login, $password) {
        $query = "Update Membre
            Set password = PASSWORD('$password')
            Where login = '$login';";
        $sth = $this->dbh->query($query);
        $sth->execute();
    }

    public function modifyRights($login, $droits) {
        $query = "Update Membre
            Set droits = '$droits'
            Where login = '$login';";
        $sth = $this->dbh->query($query);
        $sth->execute();
    }

    public function getAttributes($key) {
        $row = parent::getAttributes($key);
        $login = $row['login'];
        $password = $row['password'];
        $prenom = $row['prenom'];
        $nom = $row['nom'];
        $email = $row['email'];
        $telephone = $row['telephone'];
        $ecole = $row['ecole'];
        $annee = $row['annee'];
        $droits = $row['droits'];
        return new Membre($login, $password, $droits, $prenom, $nom, $email, $telephone, $ecole, $annee);
    }

}

?>
