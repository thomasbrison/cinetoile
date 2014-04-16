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

    /**
     * Select all the entries of the Diffusion table and containing all the information.
     * @return array An array of Diffusion
     */
    public function consult() {
        $result = parent::getAll();
        $diffusions = array();
        foreach ($result as $row) {
            $diffusions[] = $this->parseRow($row);
        }
        return $diffusions;
    }

    /**
     * Bind params to an existing PDOStatement.
     * The query of the statement must contain the following values :
     * :date_diffusion, :id_film, :cycle, :commentaire, :affiche, :nb_presents
     * @param PDOStatement $sth
     * @param Diffusion $diffusion
     */
    private function bindParams(&$sth, $diffusion) {
        $sth->bindParam(':date_diffusion', $diffusion->getDate(), PDO::PARAM_STR);
        $sth->bindParam(':id_film', $diffusion->getIdFilm(), PDO::PARAM_INT);
        $sth->bindParam(':cycle', $diffusion->getCycle(), PDO::PARAM_STR);
        $sth->bindParam(':commentaire', $diffusion->getCommentaire(), PDO::PARAM_STR);
        $sth->bindParam(':affiche', $diffusion->getAffiche(), PDO::PARAM_STR);
        $sth->bindParam(':nb_presents', $diffusion->getNbPresents(), PDO::PARAM_INT);
    }

    /**
     * Add a diffusion in the database.
     * @param Diffusion $diffusion
     * @return bool True if the diffusion has correctly been added, false if not
     */
    public function add($diffusion) {
        $query = "Insert into $this->name(date_diffusion, id_film, cycle, commentaire, affiche, nb_presents)
            Values (:date_diffusion, :id_film, :cycle, :commentaire, :affiche, :nb_presents);";
        $sth = $this->dbh->prepare($query);
        $this->bindParams($sth, $diffusion);
        return $sth->execute();
    }

    /**
     * Update a diffusion in the database.
     * @param Diffusion $diffusion
     * @return bool True if the diffusion has correctly been updated, false if not
     */
    public function update($diffusion) {
        $query = "Update $this->name
            Set id_film = :id_film, cycle = :cycle, commentaire = :commentaire, affiche = :affiche, nb_presents = :nb_presents
            Where date_diffusion = :date_diffusion;";
        $sth = $this->dbh->prepare($query);
        $this->bindParams($sth, $diffusion);
        return $sth->execute();
    }

    /**
     * Parse a row given by the query method of the PDOStatement.
     * @param array $row Row given by the query method of the PDOStatement.
     * @return Diffusion
     */
    private function parseRow($row) {
        $dateDiffusion = $row['date_diffusion'];
        $idFilm = $row['id_film'];
        $cycle = $row['cycle'];
        $commentaire = $row['commentaire'];
        $affiche = $row['affiche'];
        $nb_presents = $row['nb_presents'];
        return new Diffusion($dateDiffusion, $idFilm, $cycle, $commentaire, $affiche, $nb_presents);
    }

    /**
     * Select a row in the Diffusion table.
     * @param int $key The primary key of the diffusion
     * @return Diffusion A diffusion containing the results of the row
     */
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
