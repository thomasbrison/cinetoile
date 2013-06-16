<?php

/*
 * Controlleur des films
 */

require_once('def.php');
require_once('Models/Tables/TableFilm.php');

class filmsController extends Controller {

    private $tableFilm;

    public function __construct() {
        $this->tableFilm = new TableFilm();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        $droits = $_SESSION['droits'];
        if ($this->checkRights($droits, 1, 2)) {
            if ($droits == 2) {
                $array = $this->tableFilm->consult();
            } else if ($droits == 1) {
                $array = $this->tableFilm->consultAsAMember();
            }
            $titre_page = "Films";
            $this->render('Films/films', array('index', 'lightbox', 'style'), compact('array', 'droits', 'titre_page'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['ajouter'])) {
                $vars = $this->getInfos();
                extract($vars);
                $this->tableFilm->add($titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce);
                header('Location: ' . root . '/films.php');
            } else {
                $this->render('Films/ajout_film');
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['modifier'])) {
                $id = htmlentities(utf8_decode($_POST['id']));
                $vars = $this->getInfos();
                extract($vars);
                $this->tableFilm->modify($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce);
                header('Location: ' . root . '/films.php');
            } elseif (isset($_GET['modifier_film'])) {
                $id = htmlentities(utf8_decode($_GET['id']));
                $row = $this->tableFilm->getAttributes($id);
                $titre = $row['titre'];
                $realisateur = $row['realisateur'];
                $annee = $row['annee'];
                $pays = $row['pays'];
                $acteurs = $row['acteurs'];
                $genre = $row['genre'];
                $support = $row['support'];
                $duree = $row['duree'];
                if ($duree) {
                    $heures_duree = substr($duree, 0, 2);
                    $minutes_duree = substr($duree, 3, 2);
                }
                $synopsis = $row['synopsis'];
                $affiche = $row['affiche'];
                $_SESSION['affiche'] = $affiche;
                $bande_annonce = $row['bande_annonce'];
                $this->render('Films/modification_film', array('style'), compact('id', 'titre', 'realisateur', 'annee', 'pays', 'acteurs', 'genre', 'support', 'heures_duree', 'minutes_duree', 'synopsis', 'affiche', 'bande_annonce'));
            } else {
                header('Location: ' . root . '/films.php');
            }
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_GET['supprimer'])) {
                $id = htmlentities(utf8_decode($_GET['id']));
                $this->tableFilm->remove($id);
                header('Location: ' . root . '/films.php');
            } else {
                $this->render('Films/films');
            }
        }
    }

    public function voter() {
        if ($this->checkRights($_SESSION['droits'], 1, 1)) {
            if (isset($_POST['voter'])) {
                $id = htmlentities(utf8_decode($_GET['id']));
                $this->tableFilm->vote($id);
                // Indiquer à l'utilisateur que son vote a bien été pris en compte
            } else {
                $this->render('Films/films');
            }
        }
    }

    private function getInfos() {
        $titre = htmlentities(utf8_decode($_POST['titre']));
        $realisateur = htmlentities(utf8_decode($_POST['realisateur']));
        $annee = htmlentities(utf8_decode($_POST['annee']));
        $pays = htmlentities(utf8_decode($_POST['pays']));
        $acteurs = htmlentities(utf8_decode($_POST['acteurs']));
        $genre = htmlentities(utf8_decode($_POST['genre']));
        $support = htmlentities(utf8_decode($_POST['support']));
        $duree = htmlentities(utf8_decode($_POST['heures_duree'] . ':' . $_POST['minutes_duree']));
        $synopsis = addslashes($_POST['synopsis']);
        $bande_annonce = htmlentities($_POST['bande_annonce']);
        $etat_affiche = $_POST['etat_affiche'];
        if (!isset($etat_affiche)) {
            $etat_affiche = "1";
        }
        switch ($etat_affiche) :
            case "0" : // Affiche non modifiée
                $affiche = $_SESSION['affiche'];
                break;
            case "1" : // Affiche modifiée
                require_once 'Lib/uploadFile.php';
                $sizemax = 100000;
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $final_dir = "Images/Affiches/";
                $upload = uploadFile('affiche', $sizemax, $extensions_valides, $final_dir);
                $envoi_ok = $upload['success'];
                $message = $upload['message'];
                if ($envoi_ok) {
                    $affiche = $final_dir . $upload['file_name'];
                } else {
                    $affiche = null;
                    die($message);
                }
                break;
            case "2" : // Affiche supprimée
                $affiche = null;
                break;
            default :
                die("Etat de l'affiche non autorisé.");
        endswitch;
        $var_array = compact('titre', 'realisateur', 'annee', 'pays', 'acteurs', 'genre', 'support', 'duree', 'synopsis', 'affiche', 'bande_annonce');
        return $var_array;
    }

}

new filmsController();
?>
