<?php

/*
 * API pour accéder à la table des membres
 */

require_once('Table.php');
require_once(dirname(__FILE__) . '/../Beans/Membre.class.php');

class TableMembre extends Table {

    public function __construct() {
        parent::__construct('Membre', 'login');
    }

    public function consult() {
        $query = "Select login, prenom, nom, email, telephone, ecole, annee, droits
            From $this->name;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $login = $row['login'];
            $prenom = $row['prenom'];
            $nom = $row['nom'];
            $email = $row['email'];
            $telephone = $row['telephone'];
            $ecole = $row['ecole'];
            $annee = $row['annee'];
            $droits = (int) $row['droits'];
            $membre = new Membre($login, null, $droits, $prenom, $nom, $email, $telephone, $ecole, $annee);
            $membres[] = $membre;
        }
        return $membres;
    }

    public function add($login, $password, $droits, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Insert into $this->name(login, password, droits, prenom, nom, email, telephone, ecole, annee)
            Values ('$login', PASSWORD('$password'), '$droits', '$prenom',
                '$nom', '$email', '$tel', '$ecole', '$annee');";
        $this->dbh->query($query);
    }

    public function modify($login, $droits, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update $this->name
            Set droits = '$droits', prenom = '$prenom', nom = '$nom', email = '$email',
                telephone = '$tel', ecole = '$ecole', annee = '$annee'
            Where login = '$login';";
        $this->dbh->query($query);
    }

    // Fonction permettant de verifier que la combinaison login/password est OK
    public function authenticate($login, $password) {
        $query = "Select droits
            From $this->name
            Where login = '$login' and password = PASSWORD('$password');";
        $sth = $this->dbh->query($query);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $droits = (int) $result['droits'];
        return $droits;
    }

    public function getFirstName($login) {
        $query = "Select prenom
            From $this->name
            Where login = '$login';";
        $sth = $this->dbh->query($query);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $prenom = $result['prenom'];
        return $prenom;
    }

    public function modifyInformation(Membre $membre) {
        $login = $membre->getLogin();
        $prenom = $membre->getPrenom();
        $nom = $membre->getNom();
        $email = $membre->getEmail();
        $tel = $membre->getTelephone();
        $ecole = $membre->getEcole();
        $annee = $membre->getAnnee();
        $query = "Update $this->name
            Set prenom = '$prenom', nom = '$nom', email = '$email', telephone = '$tel',
                ecole = '$ecole', annee = '$annee'
            Where login = '$login';";
        $this->dbh->query($query);
    }

    public function modifyPassword($login, $password) {
        $query = "Update $this->name
            Set password = PASSWORD('$password')
            Where login = '$login';";
        $this->dbh->query($query);
    }

    public function modifyRights($login, $droits) {
        $query = "Update $this->name
            Set droits = '$droits'
            Where login = '$login';";
        $this->dbh->query($query);
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
        $droits = (int) $row['droits'];
        return new Membre($login, $password, $droits, $prenom, $nom, $email, $telephone, $ecole, $annee);
    }

    public function getEmails() {
        return parent::getColumn('email');
    }

    public function getMembersEmails() {
        require_once 'Lib/Rights.class.php';
        $memberRights = Rights::$MEMBER;
        $query = "SELECT email FROM $this->name WHERE droits = '$memberRights';";
        $sth = $this->dbh->query($query);
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Function to call before calling getLogins
     * @return PDOStatement
     */
    public function prepareLogin() {
        $query = "SELECT login FROM $this->name WHERE login = ?";
        return $this->dbh->prepare($query);
    }

    /**
     * Returns an array containing all the login corresponding to a login
     * Should return one or zero result
     * @param PDOStatement $sth should be returned by prepareLogin
     * @param String $login
     * @return array
     */
    public function getLogins($sth, $login) {
        $sth->execute(array($login));
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }

}

?>
