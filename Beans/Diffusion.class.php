<?php

/**
 * Description of diffusion
 *
 * @author thomas
 */
class Diffusion {

    private $date;
    protected $idFilm;
    protected $cycle;
    protected $commentaire;
    protected $affiche;
    protected $nbPresents;

    function __construct($date, $idFilm, $cycle = null, $commentaire = null, $affiche = null, $nbPresents = null) {
        $this->date = $date;
        $this->idFilm = $idFilm;
        $this->cycle = $cycle;
        $this->commentaire = $commentaire;
        $this->affiche = $affiche;
        $this->nbPresents = $nbPresents;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getIdFilm() {
        return $this->idFilm;
    }

    public function setIdFilm($id_film) {
        $this->idFilm = $id_film;
    }

    public function getCycle() {
        return $this->cycle;
    }

    public function setCycle($cycle) {
        $this->cycle = $cycle;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getNbPresents() {
        return $this->nbPresents;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function getAffiche() {
        return $this->affiche;
    }

    public function setAffiche($affiche) {
        $this->affiche = $affiche;
    }

    public function arrayInfos() {
        $date = $this->date;
        $idFilm = $this->idFilm;
        $cycle = $this->cycle;
        $commentaire = $this->commentaire;
        $affiche = $this->affiche;
        $nbPresents = $this->nbPresents;
        return compact('date', 'idFilm', 'cycle', 'commentaire', 'affiche', 'nbPresents');
    }

}

?>
