<?php

/**
 * Description of Film
 *
 * @author thomas
 */
class Film {

    private $id;
    protected $titre;
    protected $realisateur;
    protected $annee;
    protected $pays;
    protected $acteurs;
    protected $genre;
    protected $support;
    protected $duree;
    protected $synopsis;
    private $affiche;
    protected $bandeAnnonce;

    function __construct($id, $titre, $realisateur, $annee = null, $pays = null, $acteurs = null, $genre = null, $support = null, $duree = null, $synopsis = null, $affiche = null, $bande_annonce = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->realisateur = $realisateur;
        $this->annee = $annee;
        $this->pays = $pays;
        $this->acteurs = $acteurs;
        $this->genre = $genre;
        $this->support = $support;
        $this->duree = $duree;
        $this->synopsis = $synopsis;
        $this->affiche = $affiche;
        $this->bandeAnnonce = $bande_annonce;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getRealisateur() {
        return $this->realisateur;
    }

    public function setRealisateur($realisateur) {
        $this->realisateur = $realisateur;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

    public function getPays() {
        return $this->pays;
    }

    public function setPays($pays) {
        $this->pays = $pays;
    }

    public function getActeurs() {
        return $this->acteurs;
    }

    public function setActeurs($acteurs) {
        $this->acteurs = $acteurs;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function setGenre($genre) {
        $this->genre = $genre;
    }

    public function getSupport() {
        return $this->support;
    }

    public function setSupport($support) {
        $this->support = $support;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }

    public function getSynopsis() {
        return $this->synopsis;
    }

    public function setSynopsis($synopsis) {
        $this->synopsis = $synopsis;
    }

    public function getAffiche() {
        return $this->affiche;
    }

    public function setAffiche($affiche) {
        $this->affiche = $affiche;
    }

    public function getBandeAnnonce() {
        return $this->bandeAnnonce;
    }

    public function setBandeAnnonce($bande_annonce) {
        $this->bandeAnnonce = $bande_annonce;
    }

}

?>
