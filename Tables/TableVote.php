<?php

/*
 * API pour accéder à la table des votes
 */

require_once('Table.php');

class TableVote extends Table {

    public function __construct() {
        parent::__construct('Vote', 'id');
    }

    public function consult() {
        $query = "Select *
            From $this->name;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $votes = array();
        foreach ($result as $row) {
            $id = $row['id'];
            $login = $row['login'];
            $date = $row['date'];
            $id_film = $row['id_film'];
            $vote = new Vote($id, $login, $date, $id_film);
            $votes[] = $vote;
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

}

?>
