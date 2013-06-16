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
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
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
        mysql_query($query);
    }

    public function modify($login, $droits, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update Membre
            Set droits = '$droits', prenom = '$prenom', nom = '$nom', email = '$email',
                telephone = '$tel', ecole = '$ecole', annee = '$annee'
            Where login = '$login';";
        mysql_query($query);
    }

    // Fonction permettant de verifier que la combinaison login/password est OK
    public function authenticate($login, $password) {
        $query = "Select droits
            From Membre
            Where login = '$login' and password = PASSWORD('$password');";
        $result = mysql_query($query);
        $droits = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $droits = htmlentities($row['droits']);
        }
        return $droits;
    }

    public function getFirstName($login) {
        $query = "Select prenom
            From Membre
            Where login = '$login';";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        $prenom = $row['prenom'];
        return $prenom;
    }

}

?>
