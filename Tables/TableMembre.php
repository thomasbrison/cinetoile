<?php

require_once('Table.php');
require_once('Beans/Membre.class.php');

/**
 * API pour accéder à la table des membres
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableMembre extends Table {

    public function __construct() {
        parent::__construct('Membre', 'login');
    }

    /**
     * Select all the entries of the Membre table and containing all the information except the password.
     * @return array An array of Membre
     */
    public function consult() {
        $query = "Select login, prenom, nom, email, telephone, ecole, annee, droits
            From $this->name;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $membres[] = $this->parseRow($row);
        }
        return $membres;
    }

    /**
     * Add a member in the database
     * @param Membre $membre
     * @return bool True if the member has correctly been added, false if not
     */
    public function add($membre) {
        $query = "Insert into $this->name(login, password, droits, prenom, nom, email, telephone, ecole, annee)
            Values (:login, PASSWORD(:password), :droits, :prenom, :nom, :email, :telephone, :ecole, :annee);";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':login', $membre->getLogin(), PDO::PARAM_STR);
        $sth->bindParam(':password', $membre->getPassword(), PDO::PARAM_STR);
        $sth->bindParam(':droits', $membre->getDroits(), PDO::PARAM_INT);
        $sth->bindParam(':prenom', $membre->getPrenom(), PDO::PARAM_STR);
        $sth->bindParam(':nom', $membre->getNom(), PDO::PARAM_STR);
        $sth->bindParam(':email', $membre->getEmail(), PDO::PARAM_STR);
        $sth->bindParam(':telephone', $membre->getTelephone(), PDO::PARAM_STR);
        $sth->bindParam(':ecole', $membre->getEcole(), PDO::PARAM_STR);
        $sth->bindParam(':annee', $membre->getAnnee(), PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Modify the information of a member :
     * droits, prenom, nom, email, telephone, ecole, annee
     * @param Membre $membre
     * @return bool True if the entry has correctly been updated, false if not
     */
    public function update($membre) {
        $query = "Update $this->name
            Set droits = :droits, prenom = :prenom, nom = :nom, email = :email, telephone = :telephone,
                ecole = :ecole, annee = :annee
            Where login = :login;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':droits', $membre->getDroits(), PDO::PARAM_INT);
        $sth->bindParam(':prenom', $membre->getPrenom(), PDO::PARAM_STR);
        $sth->bindParam(':nom', $membre->getNom(), PDO::PARAM_STR);
        $sth->bindParam(':email', $membre->getEmail(), PDO::PARAM_STR);
        $sth->bindParam(':telephone', $membre->getTelephone(), PDO::PARAM_STR);
        $sth->bindParam(':ecole', $membre->getEcole(), PDO::PARAM_STR);
        $sth->bindParam(':annee', $membre->getAnnee(), PDO::PARAM_INT);
        $sth->bindParam(':login', $membre->getLogin(), PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Parse a row given by the query method of the PDOStatement.
     * @param array $row Row given by the query method of the PDOStatement.
     * @return Membre The parsed member
     */
    private function parseRow($row) {
        $login = $row['login'];
        $password = isset($row['password']) ? $row['password'] : NULL;
        $prenom = $row['prenom'];
        $nom = $row['nom'];
        $email = $row['email'];
        $telephone = $row['telephone'];
        $ecole = $row['ecole'];
        $annee = isset($row['annee']) ? (int) $row['annee'] : NULL;
        $droits = (int) $row['droits'];
        return new Membre($login, $password, $droits, $prenom, $nom, $email, $telephone, $ecole, $annee);
    }

    /**
     * Function that returns the right number of a user.
     * @param string $login
     * @param string $password
     * @return int Rights number
     */
    public function authenticate($login, $password) {
        $query = "Select droits
            From $this->name
            Where login = :login and password = PASSWORD(:password);";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        if ($sth->execute()) {
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $droits = (int) $result['droits'];
        }
        return $droits;
    }

    /**
     * Get the first name of a member.
     * @param string $login The login of the member
     * @return string The first name of the member
     */
    public function getFirstName($login) {
        $query = "Select prenom
            From $this->name
            Where login = :login;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        if ($sth->execute()) {
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $prenom = $result['prenom'];
        }
        return $prenom;
    }

    /**
     * Modify the information of a member :
     * prenom, nom, email, telephone, ecole, annee
     * @param Membre $membre
     * @return bool True if the entry has correctly been updated, false if not
     */
    public function modifyInformation(Membre $membre) {
        $query = "Update $this->name
            Set prenom = :prenom, nom = :nom, email = :email, telephone = :telephone,
                ecole = :ecole, annee = :annee
            Where login = :login;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':prenom', $membre->getPrenom(), PDO::PARAM_STR);
        $sth->bindParam(':nom', $membre->getNom(), PDO::PARAM_STR);
        $sth->bindParam(':email', $membre->getEmail(), PDO::PARAM_STR);
        $sth->bindParam(':telephone', $membre->getTelephone(), PDO::PARAM_STR);
        $sth->bindParam(':ecole', $membre->getEcole(), PDO::PARAM_STR);
        $sth->bindParam(':annee', $membre->getAnnee(), PDO::PARAM_INT);
        $sth->bindParam(':login', $membre->getLogin(), PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Modify the password of a member.
     * @param string $login Login of the user for whom to change the password
     * @param string $password New password
     * @return bool True if the entry has correctly been updated, false if not
     */
    public function modifyPassword($login, $password) {
        $query = "Update $this->name
            Set password = PASSWORD(:password)
            Where login = :login;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Modify the rigths for a user.
     * @param string $login Login of the user for whom to change the rights
     * @param int $droits New rigths number
     * @return bool True if the entry has correctly been updated, false if not
     */
    public function modifyRights($login, $droits) {
        $query = "Update $this->name
            Set droits = :droits
            Where login = :login;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':droits', $droits, PDO::PARAM_INT);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Select a row in the Membre table.
     * @param string $key The login of the member
     * @return array A member containing the results of the row
     */
    public function getAttributes($key) {
        $row = parent::getAttributes($key);
        return $this->parseRow($row);
    }

    /**
     * Select all the emails.
     * @return array An array of emails
     */
    public function getEmails() {
        return parent::getColumn('email');
    }

    /**
     * Select the emails of the members.
     * @return array An array of emails
     */
    public function getMembersEmails() {
        require_once 'Lib/Rights.class.php';
        $query = "SELECT email FROM $this->name WHERE droits = :droits;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':droits', Rights::$MEMBER, PDO::PARAM_INT);
        if ($sth->execute()) {
            return $sth->fetchAll(PDO::FETCH_COLUMN);
        }
        return NULL;
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
     * Return an array containing all the login corresponding to a login
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
