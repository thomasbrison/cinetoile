<?php

/**
 * Description of diffusion
 *
 * @author thomas
 */
class Diffusion {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    protected $date;
    /**
     * @var int
     */
    protected $idFilm;
    /**
     * @var string
     */
    protected $cycle;
    /**
     * @var string
     */
    protected $commentaire;
    /**
     * @var string
     */
    protected $affiche;
    /**
     * @var int
     */
    protected $nbPresents;

    function __construct($id, $date, $idFilm, $cycle = null, $commentaire = null, $affiche = null, $nbPresents = null) {
        $this->id = $id;
        $this->date = $date;
        $this->idFilm = $idFilm;
        $this->cycle = $cycle;
        $this->commentaire = $commentaire;
        $this->affiche = $affiche;
        $this->nbPresents = $nbPresents;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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
