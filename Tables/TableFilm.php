<?php

/*
 * Modèle pour les films
 */

require_once('Table.php');

class TableFilm extends Table {

    static $name = 'Film';
    static $primaryKey = 'id';

    public function __construct() {
        parent::__construct(self::$name, self::$primaryKey);
    }

    public function consult() {
        $query = "Select *
            From Film
            Order By titre;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $id = $row['id'];
            $titre = $row['titre'];
            $realisateur = $row['realisateur'];
            $annee = $row['annee'];
            $pays = $row['pays'];
            $acteurs = $row['acteurs'];
            $genre = $row['genre'];
            $support = $row['support'];
            $duree = $row['duree'];
            $synopsis = $row['synopsis'];
            $affiche = $row['affiche'];
            $bandeAnnonce = $row['bande_annonce'];
            $film = new Film($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bandeAnnonce);
            $films[] = $film;
        }
        return $films;
    }

    public function consultAsAMember() {
        $query = "Select id, titre, realisateur, annee, pays, acteurs, genre, synopsis, affiche, bande_annonce
            From Film
            Order By titre;";
        $sth = $this->dbh->query($query);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $id = $row['id'];
            $titre = $row['titre'];
            $realisateur = $row['realisateur'];
            $annee = $row['annee'];
            $pays = $row['pays'];
            $acteurs = $row['acteurs'];
            $genre = $row['genre'];
            $synopsis = $row['synopsis'];
            $affiche = $row['affiche'];
            $bandeAnnonce = $row['bande_annonce'];
            $film = new Film($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, null, null, $synopsis, $affiche, $bandeAnnonce);
            $films[] = $film;
        }
        return $films;
    }

    public function add($titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce) {
        $query = "Insert into Film(titre, realisateur, annee, pays, acteurs, genre, support,
            duree, synopsis, affiche, bande_annonce)
            Values ('$titre', '$realisateur', '$annee', '$pays', '$acteurs', '$genre', '$support',
                '$duree', '$synopsis', '$affiche', '$bande_annonce');";
        $this->dbh->query($query);
    }

    public function modify($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce) {
        $query = "Update Film
            Set titre = '$titre', realisateur = '$realisateur', annee = '$annee', pays = '$pays',
                acteurs = '$acteurs', genre = '$genre', support = '$support', duree = '$duree',
                synopsis = '$synopsis', affiche = '$affiche', bande_annonce = '$bande_annonce' 
            Where id = '$id';";
        $this->dbh->query($query);
    }

    public function vote($id) {
        // TODO
    }

}

?>
