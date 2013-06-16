<?php

/*
 * Modèle pour les votes
 */

require("connexion.php");

class Vote extends Table {

    //Tout revoir

    public function __construct() {
        parent::__construct('VoteFilm', 'IdFilm');
    }

    public function consulterVotesFilms() {
        $query = "Select * 
                      From VoteFilm
                      Order By nombre_votes
                      Limit 0, 5;";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $array[] = $row;
        }
        return $array;
    }

    /* On suppose que la vérification sur la date du vote a été faite avant */

    private function ajouterVoteFilm($id_film) {
        $query1 = "Select nombre_votes
                    From VoteFilm
                    Where id='$id';";
        $nb_votes = mysql_fetch_field($query1) + 1;
        $query2 = "Insert into VoteFilm(id,nombre_votes,) 
                      values ('$id','$nb_votes');";
        mysql_query($query);
    }

    private function ajouterVoteMembre($login, $id_film) {
        //$date_vote = date('Y').'-'.date('m').'-'.date('d').' '.da
        $date_vote = date('c');
        $query = "Insert into VoteMembre(login,id_film,date_vote) 
                      values ('$login','$id_film','$date_vote');";
        mysql_query($query);
    }

    private function peutVoter($login) {
        return true;
    }

    public function ajouterVote($login, $id_film) {
        if ($this->peutVoter($login)) {
            $this->ajouterVoteFilm($id_film);
            $this->ajouterVoteMembre($login, $id_film);
        }
    }

    //Fonction à revoir
    public function modifierVoteFilm($id, $login, $date_vote) {
        $query1 = "Select nombre_votes
                    From VoteFilm
                    Where id='$id';";
        $nb_votes = mysql_fetch_field($query1) - 1;
        $query = "Update VoteFilm
                      Set id_film='$id', nombre_votes='$nb_votes' login='$login', date_vote='$date_vote'
                      where id = '$id';";
        mysql_query($query);
    }

    private function supprimerVoteFilm($id_film) {
        $query1 = "Select nombre_votes
                    From VoteFilm
                    Where id_film='$id_film';";
        $nb_votes = mysql_fetch_field($query1) - 1;
        $query2 = "Update VoteFilm
                      Set nombre_votes='$nb_votes'
                      Where id_film='$id_film";
        mysql_query($query2);
    }

    private function supprimerVoteMembre($login) {
        $query = "Delete From VoteMembre
                      where login = '$login';";
        mysql_query($query);
    }

    public function supprimerVote($login) {
        $query = "Select id_film
                    From VoteMembre
                    Where login='$login';";
        $id_film = mysql_fetch_field($query);
        $this->supprimerVoteFilm($id_film);
        $this->supprimerVoteMembre($login);
    }

    public function modifierInformations($login, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update VoteFilm
                      Set prenom='$prenom', nom='$nom', email='$email', telephone='$tel', ecole='$ecole', annee='$annee'
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifierMotDePasse($login, $password) {
        $query = "Update VoteFilm
                      Set password=PASSWORD('$password')
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifierDroits($login, $droits) {
        $query = "update VoteFilm
                      set droits='$droits'
                      where login = '$login';";
        mysql_query($query);
    }

    public function consult() {
        
    }

}

class VoteFilm extends Table {

    public function __construct() {
        $name = 'VoteFilm';
        parent::__construct($name);
    }

    public function consulterVotesFilms() {
        $query = "Select * 
                      From VoteFilm
                      Order By nombre_votes
                      Limit 0, 5;";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $array[] = $row;
        }
        return $array;
    }

    /* On suppose que la vérification sur la date du vote a été faite avant */

    public function ajouterVoteFilm($id, $login, $date_vote) {
        $query1 = "Select nombre_votes
                    From VoteFilm
                    Where id='$id';";
        $nb_votes = mysql_fetch_field($query1) + 1;
        $query2 = "Insert into VoteFilm(id,nombre_votes,login,date_vote) 
                      values ('$id','$nb_votes','$login','$date_vote');";
        mysql_query($query);
    }

    public function modifierVoteFilm($id, $login, $date_vote) {
        $query1 = "Select nombre_votes
                    From VoteFilm
                    Where id='$id';";
        $nb_votes = mysql_fetch_field($query1) - 1;
        $query = "Update VoteFilm
                      Set id='$id', nombre_votes='$nb_votes' login='$login', date_vote='$date_vote'
                      where id = '$id';";
        mysql_query($query);
    }

    public function supprimerVoteFilm($login) {
        $query = "Delete From VoteFilm
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifierInformations($login, $prenom, $nom, $email, $tel, $ecole, $annee) {
        $query = "Update VoteFilm
                      Set prenom='$prenom', nom='$nom', email='$email', telephone='$tel', ecole='$ecole', annee='$annee'
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifierMotDePasse($login, $password) {
        $query = "Update VoteFilm
                      Set password=PASSWORD('$password')
                      where login = '$login';";
        mysql_query($query);
    }

    public function modifierDroits($login, $droits) {
        $query = "update VoteFilm
                      set droits='$droits'
                      where login = '$login';";
        mysql_query($query);
    }

    public function consult() {
        
    }

}
?>

