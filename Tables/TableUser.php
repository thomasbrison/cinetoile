<?php

/*
 * Definition d'un utilisateur
 */

require_once('Table.php');

class TableUser extends Table {

    static $name = 'Membre';
    static $primaryKey = 'login';

    public function __construct() {
        parent::__construct(self::$name, self::$primaryKey);
    }

    public function consult() {
        $query = "Select login, prenom, nom, email, telephone, ecole, annee, droits
            From Membre;";
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
            $droits = $row['droits'];
            $membre = new Membre($login, null, $droits, $prenom, $nom, $email, $telephone, $ecole, $annee);
            $membres[] = $membre;
        }
        return $membres;
    }

    public function add($login, $password, $droits, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Insert into Membre(login, password, droits, prenom, nom, email, telephone, ecole, annee)
            Values ('$login', PASSWORD('$password'), '$droits', '$prenom',
                '$nom', '$email', '$tel', '$ecole', '$annee');";
        $sth = $this->dbh->query($query);
        $sth->execute();
    }

    public function modify($login, $droits, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update Membre
            Set droits = '$droits', prenom = '$prenom', nom = '$nom', email = '$email',
                telephone = '$tel', ecole = '$ecole', annee = '$annee'
            Where login = '$login';";
        $sth = $this->dbh->query($query);
        $sth->execute();
    }

    // Fonction permettant de verifier que la combinaison login/password est OK
    public function authenticate($login, $password) {
        $query = "Select droits
            From Membre
            Where login = '$login' and password = PASSWORD('$password');";
        $sth = $this->dbh->query($query);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $droits = $result['droits'] or 0;
        return $droits;
    }

    public function getFirstName($login) {
        $query = "Select prenom
            From Membre
            Where login = '$login';";
        $sth = $this->dbh->query($query);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $prenom = $result['prenom'];
        return $prenom;
    }

}

?>
