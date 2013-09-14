<?php

require_once('Table.php');

/**
 * API pour accéder à la table des films
 *
 * @author thomas.brison@grenoble-inp.org
 */
class TableFilm extends Table {

    public function __construct() {
        parent::__construct('Film', 'id');
    }

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

    public function add($film) {
        extract($film->arrayInfos());
        $query = "Insert into $this->name(titre, realisateur, annee, pays, acteurs, genre, support,
            duree, synopsis, affiche, bande_annonce)
            Values ('$titre', '$realisateur', $annee, '$pays', '$acteurs', '$genre', $support,
                $duree, '$synopsis', '$affiche', '$bandeAnnonce');";
        $this->dbh->query($query);
    }

    public function update($film) {
        extract($film->arrayInfos());
        $query = "Update $this->name
            Set titre = '$titre', realisateur = '$realisateur', annee = $annee, pays = '$pays',
                acteurs = '$acteurs', genre = '$genre', support = $support, duree = $duree,
                synopsis = '$synopsis', affiche = '$affiche', bande_annonce = '$bandeAnnonce'
            Where id = '$id';";
        $this->dbh->query($query);
    }

    private function parseRow($row) {
        $id = $row['id'];
        $titre = $row['titre'];
        $realisateur = $row['realisateur'];
        $annee = $row['annee'];
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

}

?>
