<?php

/*
 * Modèle pour les films
 */

require_once('table.php');

class Film extends Table {

    // On se connecte à la BD au moment où crée une instance de Film

    public function __construct() {
        parent::__construct('Film','id');
    }
    
    public function consult() {
        $query = "Select *
                      From Film
                      Order By titre;";
        $result=mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $array[]=$row;
        }
        return $array;
    }
    
    public function consultAsAMember() {
        $query = "Select id, titre, realisateur, annee, pays, acteurs, genre, synopsis, affiche, bande_annonce
                      From Film
                      Order By titre;";
        $result=mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $array[]=$row;
        }
        return $array;
    }

    public function add($titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce) {
        $query = "Insert into Film(titre, realisateur, annee, pays, acteurs, genre, support, duree, synopsis, affiche, bande_annonce) 
                      values ('$titre', '$realisateur', '$annee', '$pays', '$acteurs', '$genre', '$support', '$duree', '$synopsis', '$affiche', '$bande_annonce');";
        mysql_query($query);
    }
    
    public function modify($id,$titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce) {
        $query = "Update Film
                      Set titre='$titre', realisateur='$realisateur', annee='$annee', pays='$pays', acteurs='$acteurs', genre='$genre', support='$support', duree='$duree', synopsis='$synopsis', affiche='$affiche', bande_annonce='$bande_annonce'
                      where id = '$id';";
        mysql_query($query);
    }
    
    public function vote($id) {
        // TODO
    }

}

?>
