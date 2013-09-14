<?php

require_once('Table.php');

/**
 * API pour accéder à la table des diffusions
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableDiffusion extends Table {

    public function __construct() {
        parent::__construct('Diffusion', 'date_diffusion');
    }

    public function consult() {
        $result = parent::getAll();
        $diffusions = array();
        foreach ($result as $row) {
            $diffusions[] = $this->parseRow($row);
        }
        return $diffusions;
    }

    public function add($diffusion) {
        extract($diffusion->arrayInfos());
        $query = "Insert into $this->name(date_diffusion, id_film, cycle, commentaire, affiche, nb_presents)
            Values ('$date', '$idFilm', '$cycle', '$commentaire', '$affiche', '$nbPresents');";
        $this->dbh->query($query);
    }

    public function update($diffusion) {
        extract($diffusion->arrayInfos());
        $query = "Update $this->name
            Set id_film = '$idFilm', cycle = '$cycle', commentaire = '$commentaire', affiche = '$affiche', nb_presents = '$nbPresents'
            Where date_diffusion = '$date';";
        $this->dbh->query($query);
    }

    private function parseRow($row) {
        $dateDiffusion = $row['date_diffusion'];
        $idFilm = $row['id_film'];
        $cycle = $row['cycle'];
        $commentaire = $row['commentaire'];
        $affiche = $row['affiche'];
        $nb_presents = $row['nb_presents'];
        return new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche, $nb_presents);
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
