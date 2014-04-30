<?php

/**
 * API pour accéder à la table des votes
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableVote extends Table {

    public function __construct() {
        parent::__construct('Vote', 'id');
    }

    public function consult() {
        $result = parent::getAll();
        $votes = array();
        foreach ($result as $row) {
            $votes[] = $this->parseRow($row);
        }
        return $votes;
    }

    public function add($vote) {
        extract($vote->arrayInfos());
        $query = "Insert into $this->name(login, date, id_film)
            Values ('$login', '$date', $idFilm);";
        $this->dbh->query($query);
    }

    public function update($vote) {
        extract($vote->arrayInfos());
        $query = "Update $this->name
            Set login = '$login', date = '$date', id_film = $idFilm
            Where id = $id;";
        $this->dbh->query($query);
    }

    private function parseRow($row) {
        $id = isset($row['id']) ? $row['id'] : NULL;
        $login = isset($row['login']) ? $row['login'] : NULL;
        $date = isset($row['date']) ? $row['date'] : NULL;
        $id_film = isset($row['id_film']) ? $row['id_film'] : NULL;
        return new Vote($id, $login, $date, $id_film);
    }

    public function selectVotes($login) {
        $query = "SELECT * "
                . "FROM $this->name "
                . "WHERE login = '$login'";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $votes = array();
        foreach ($result as $row) {
            $votes[] = $this->parseRow($row);
        }
        return $votes;
    }

}

?>
