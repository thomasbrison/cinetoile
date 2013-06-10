<?php

/*
 * Modèle pour les diffusions
 */

require_once('table.php');

class Diffusion extends Table {

    public function __construct() {
        parent::__construct('Diffusion','date_diffusion');
    }
    
    public function consult() {
        $result=parent::getAll();
        while ($row = mysql_fetch_assoc($result)) {
            $array[]=$row;
        }
        return $array;
    }

    public function add($date, $id_film, $cycle, $commentaire, $affiche) {
        $query = "Insert into Diffusion(date_diffusion,id_film,commentaire,affiche) 
                      Values ('$date', '$id_film', '$cycle', '$commentaire', '$affiche');";
        mysql_query($query);
    }
    
    public function modify($date, $id_film, $cycle, $commentaire, $affiche) {
        $query = "Update Diffusion
                      Set id_film='$id_film', cycle='$cycle', commentaire='$commentaire', affiche='$affiche'
                      Where date_diffusion='$date';";
        mysql_query($query);
    }
    
    public function classifyByDate() {
        $diffusions=$this->consulterDiffusions();
        $now=date('c');
    }
    
}

?>
