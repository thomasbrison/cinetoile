<?php

/**
 * Description of Selection
 *
 * @author thomas
 */
class Selection {

    private $id;
    protected $date;
    protected $idFilm;
    protected $isActive;

    function __construct($id, $date, $idFilm, $isActive) {
        $this->id = $id;
        $this->date = $date;
        $this->idFilm = $idFilm;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getIdFilm() {
        return $this->idFilm;
    }

    public function isActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setIdFilm($idFilm) {
        $this->idFilm = $idFilm;
    }

    public function setActive($isActive) {
        $this->isActive = $isActive;
    }

    public function arrayInfos() {
        $id = $this->id;
        $date = $this->date;
        $idFilm = $this->idFilm;
        $isActive = $this->isActive();
        return compact('id', 'date', 'idFilm', 'isActive');
    }

}

?>
