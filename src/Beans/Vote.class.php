<?php

/**
 * Description of Vote
 *
 * @author thomas
 */
class Vote {

    private $id;
    protected $login;
    protected $date;
    protected $idFilm;

    function __construct($id, $login, $date, $idFilm) {
        $this->id = $id;
        $this->login = $login;
        $this->date = $date;
        $this->idFilm = $idFilm;
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getDate() {
        return $this->date;
    }

    public function getIdFilm() {
        return $this->idFilm;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setIdFilm($idFilm) {
        $this->idFilm = $idFilm;
    }

    public function arrayInfos() {
        $id = $this->id;
        $login = $this->login;
        $date = $this->date;
        $idFilm = $this->idFilm;
        return compact('id', 'login', 'date', 'idFilm');
    }

}

?>
