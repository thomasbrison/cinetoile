<?php

/**
 * Description of membre
 *
 * @author thomas
 */
class Membre {

    private $login;
    private $password;
    protected $droits;
    protected $prenom;
    protected $nom;
    protected $email;
    protected $telephone;
    protected $ecole;
    protected $annee;

    function __construct($login, $password = null, $droits = 1, $prenom = null, $nom = null, $email = null, $telephone = null, $ecole = null, $annee = null) {
        $this->login = $login;
        $this->password = $password;
        $this->droits = $droits;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->ecole = $ecole;
        $this->annee = $annee;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getDroits() {
        return $this->droits;
    }

    public function setDroits($droits) {
        $this->droits = $droits;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getEcole() {
        return $this->ecole;
    }

    public function setEcole($ecole) {
        $this->ecole = $ecole;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

}

?>
