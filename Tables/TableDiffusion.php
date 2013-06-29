<?php

/*
 * Modèle pour les diffusions
 */

require_once('Table.php');

class TableDiffusion extends Table {

    static $name = 'Diffusion';
    static $primaryKey = 'date_diffusion';

    public function __construct() {
        parent::__construct(self::$name, self::$primaryKey);
    }

    public function consult() {
        $result = parent::getAll();
        while ($row = mysql_fetch_assoc($result)) {
            $dateDiffusion = $row['date_diffusion'];
            $idFilm = $row['id_film'];
            $cycle = $row['cycle'];
            $commentaire = $row['commentaire'];
            $affiche = $row['affiche'];
            $diffusion = new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche);
            $diffusions[] = $diffusion;
        }
        return $diffusions;
    }

    public function add($date, $id_film, $cycle, $commentaire, $affiche) {
        $query = "Insert into Diffusion(date_diffusion, id_film, cycle, commentaire, affiche)
            Values ('$date', '$id_film', '$cycle', '$commentaire', '$affiche');";
        mysql_query($query);
    }

    public function modify($date, $id_film, $cycle, $commentaire, $affiche) {
        $query = "Update Diffusion
            Set id_film = '$id_film', cycle = '$cycle', commentaire = '$commentaire', affiche = '$affiche'
            Where date_diffusion = '$date';";
        mysql_query($query);
    }

    public function classifyByDate() {
        $diffusions = $this->consulterDiffusions();
        $now = date('c');
    }

    public function getAttributes($key) {
        $row = parent::getAttributes($key);
        $dateDiffusion = $row['date_diffusion'];
        $idFilm = $row['id_film'];
        $cycle = $row['cycle'];
        $commentaire = $row['commentaire'];
        $affiche = $row['affiche'];
        return new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche);
    }

}

?>
