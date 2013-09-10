<?php

/*
 * API pour accéder à la table des diffusions
 */

require_once('Table.php');

class TableDiffusion extends Table {

    public function __construct() {
        parent::__construct('Diffusion', 'date_diffusion');
    }

    public function consult() {
        $result = parent::getAll();
        $diffusions = array();
        foreach ($result as $row) {
            $dateDiffusion = $row['date_diffusion'];
            $idFilm = $row['id_film'];
            $cycle = $row['cycle'];
            $commentaire = $row['commentaire'];
            $affiche = $row['affiche'];
            $nb_presents = $row['nb_presents'];
            $diffusion = new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche, $nb_presents);
            $diffusions[] = $diffusion;
        }
        return $diffusions;
    }

    public function add($date, $id_film, $cycle, $commentaire, $affiche, $nb_presents) {
        $query = "Insert into $this->name(date_diffusion, id_film, cycle, commentaire, affiche, nb_presents)
            Values ('$date', '$id_film', '$cycle', '$commentaire', '$affiche', '$nb_presents');";
        $this->dbh->query($query);
    }

    public function modify($date, $id_film, $cycle, $commentaire, $affiche, $nb_presents) {
        $query = "Update $this->name
            Set id_film = '$id_film', cycle = '$cycle', commentaire = '$commentaire', affiche = '$affiche', nb_presents = '$nb_presents'
            Where date_diffusion = '$date';";
        $this->dbh->query($query);
    }

    public function getAttributes($key) {
        $row = parent::getAttributes($key);
        $dateDiffusion = $row['date_diffusion'];
        $idFilm = $row['id_film'];
        $cycle = $row['cycle'];
        $commentaire = $row['commentaire'];
        $affiche = $row['affiche'];
        $nb_presents = $row['nb_presents'];
        return new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche, $nb_presents);
    }

    /**
     * @author Maxence
     * @date 25/08/2013
     * @brief Retourne le numéro de page de la prochaine diffusion
     */
    public function pageOfNextDiffusion() {
        $page = -1;
        $result = parent::getColumn('date_diffusion');
        foreach ($result as $value) {
            $timeDiffusion = strtotime($value);
            if ($timeDiffusion > time()) {
                $page++;
            }
        }
        return $page < 0 ? 0 : $page;
    }

}

?>
