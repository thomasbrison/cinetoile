<?php

/**
 * API pour accéder à la table des sélections de films
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableSelection extends Table {

    function __construct() {
        parent::__construct('Selection', 'id');
    }

    public function add($selection) {
        extract($selection->arrayInfos());
        $query = "INSERT INTO $this->name(date, id_film, is_active)
            VALUES ('$date', $idFilm, $isActive);";
        $this->dbh->query($query);
    }

    public function consult() {
        $result = parent::getAll();
        $selections = array();
        foreach ($result as $row) {
            $selections[] = $this->parseRow($row);
        }
        return $selections;
    }

    public function update($selection) {
        extract($selection->arrayInfos());
        $query = "UPDATE $this->name
            SET date = '$date', id_film = $idFilm, is_active = $isActive
            WHERE id = $id;";
        $this->dbh->query($query);
    }

    private function parseRow($row) {
        $id = $row['id'];
        $date = $row['date'];
        $id_film = $row['id_film'];
        $is_active = $row['is_active'];
        return new Selection($id, $date, $id_film, $is_active);
    }

}

?>
