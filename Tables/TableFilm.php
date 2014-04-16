<?php

require_once('Table.php');
require_once('Beans/Film.class.php');

/**
 * API pour accéder à la table des films
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableFilm extends Table {

    public function __construct() {
        parent::__construct('Film', 'id');
    }

    /**
     * Select all the entries of the Film table and containing all the information, ordered by title.
     * @return array An array of Film
     */
    public function consult() {
        $query = "Select *
            From $this->name
            Order By titre;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $films = array();
        foreach ($result as $row) {
            $films[] = $this->parseRow($row);
        }
        return $films;
    }

    /**
     * Select all the entries of the Film table ordered by title and containing
     * the id, the title, the director, the year, the country, the kind, the synopsis, the poster and the trailer.
     * @return array An array of Film
     */
    public function consultAsAMember() {
        $query = "Select id, titre, realisateur, annee, pays, acteurs, genre, synopsis, affiche, bande_annonce
            From $this->name
            Order By titre;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $films = array();
        foreach ($result as $row) {
            $films[] = $this->parseRow($row);
        }
        return $films;
    }

    /**
     * Bind params to an existing PDOStatement.
     * The query of the statement must contain the following values :
     * :titre, :realisateur, :annee, :pays, :acteurs, :genre, :support, :duree, :synopsis, :affiche, :bande_annonce
     * @param PDOStatement $sth
     * @param Film $film
     */
    private function bindParams(&$sth, $film) {
        $sth->bindParam(':titre', $film->getTitre(), PDO::PARAM_STR);
        $sth->bindParam(':realisateur', $film->getRealisateur(), PDO::PARAM_STR);
        $sth->bindParam(':annee', $film->getAnnee(), PDO::PARAM_INT);
        $sth->bindParam(':pays', $film->getPays(), PDO::PARAM_STR);
        $sth->bindParam(':acteurs', $film->getActeurs(), PDO::PARAM_STR);
        $sth->bindParam(':genre', $film->getGenre(), PDO::PARAM_STR);
        $sth->bindParam(':support', $film->getSupport(), PDO::PARAM_STR);
        $sth->bindParam(':duree', $film->getDuree(), PDO::PARAM_STR);
        $sth->bindParam(':synopsis', $film->getSynopsis(), PDO::PARAM_STR);
        $sth->bindParam(':affiche', $film->getAffiche(), PDO::PARAM_STR);
        $sth->bindParam(':bande_annonce', $film->getBandeAnnonce(), PDO::PARAM_STR);
    }

    /**
     * Add a film in the database
     * @param Film $film
     * @return bool True if the film has correctly been added, false if not
     */
    public function add($film) {
        extract($film->arrayInfos());
        $query = "Insert into $this->name(titre, realisateur, annee, pays, acteurs, genre, support,
            duree, synopsis, affiche, bande_annonce)
            Values (:titre, :realisateur, :annee, :pays, :acteurs, :genre, :support,
                :duree, :synopsis, :affiche, :bande_annonce);";
        $sth = $this->dbh->prepare($query);
        $this->bindParams($sth, $film);
        return $sth->execute();
    }

    /**
     * Update a film in the database
     * @param Film $film
     * @return bool True if the film has correctly been updated, false if not
     */
    public function update($film) {
        $query = "Update $this->name
            Set titre = :titre, realisateur = :realisateur, annee = :annee, pays = :pays,
                acteurs = :acteurs, genre = :genre, support = :support, duree = :duree,
                synopsis = :synopsis, affiche = :affiche, bande_annonce = :bande_annonce
            Where id = :id;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':titre', $film->getTitre(), PDO::PARAM_STR);
        $sth->bindParam(':realisateur', $film->getRealisateur(), PDO::PARAM_STR);
        $sth->bindParam(':annee', $film->getAnnee(), PDO::PARAM_INT);
        $sth->bindParam(':pays', $film->getPays(), PDO::PARAM_STR);
        $sth->bindParam(':acteurs', $film->getActeurs(), PDO::PARAM_STR);
        $sth->bindParam(':genre', $film->getGenre(), PDO::PARAM_STR);
        $sth->bindParam(':support', $film->getSupport(), PDO::PARAM_STR);
        $sth->bindParam(':duree', $film->getDuree(), PDO::PARAM_STR);
        $sth->bindParam(':synopsis', $film->getSynopsis(), PDO::PARAM_STR);
        $sth->bindParam(':affiche', $film->getAffiche(), PDO::PARAM_STR);
        $sth->bindParam(':bande_annonce', $film->getBandeAnnonce(), PDO::PARAM_STR);
        $sth->bindParam(':id', $film->getId(), PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Parse a row given by the query method of the PDOStatement.
     * @param array $row Row given by the query method of the PDOStatement.
     * @return Film
     */
    private function parseRow($row) {
        $id = $row['id'];
        $titre = $row['titre'];
        $realisateur = $row['realisateur'];
        $annee = isset($row['annee']) ? (int) $row['annee'] : NULL;
        $pays = $row['pays'];
        $acteurs = $row['acteurs'];
        $genre = $row['genre'];
        $support = isset($row['support']) ? $row['support'] : NULL;
        $duree = isset($row['duree']) ? $row['duree'] : NULL;
        $synopsis = $row['synopsis'];
        $affiche = $row['affiche'];
        $bandeAnnonce = $row['bande_annonce'];
        return new Film($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bandeAnnonce);
    }

    /**
     * Select a row in the Film table.
     * @param int $key The primary key of the film
     * @return Film An film containing the results of the row
     */
    public function getAttributes($key) {
        $row = parent::getAttributes($key);
        return $this->parseRow($row);
    }

}

?>
