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

    function __construct($date, $id_film, $cycle = null, $commentaire = null, $affiche = null, $nbPresents = null) {
        $this->date = $date;
        $this->idFilm = $id_film;
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

}

?>
