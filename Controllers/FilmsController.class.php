<?php

require_once 'Controller.class.php';
require_once 'Beans/Film.class.php';
require_once 'Tables/TableFilm.php';

class FilmsController extends Controller {

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
        if ($this->checkRights($droits, Rights::$MEMBER, Rights::$ADMIN)) {
            if ($droits == Rights::$ADMIN) {
                $films = $this->tableFilm->consult();
            } else if ($droits == Rights::$MEMBER) {
                $films = $this->tableFilm->consultAsAMember();
            }
            $titre_page = "Films";
            $this->render('Films/films', array('effets', 'lightbox'), compact('films', 'droits', 'titre_page'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['ajouter'])) {
                $film = $this->getInfos(null);
                $this->tableFilm->add($film->getTitre(), $film->getRealisateur(), $film->getAnnee(), $film->getPays(), $film->getActeurs(), $film->getGenre(), $film->getSupport(), $film->getDuree(), $film->getSynopsis(), $film->getAffiche(), $film->getBandeAnnonce());
                header('Location: ' . root . '/films.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/films.php');
            } else {
                $this->render('Films/ajout_film');
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['modifier'])) {
                $id = htmlentities(utf8_decode($_POST['id']));
                $film = $this->getInfos($id);
                $this->tableFilm->modify($id, $film->getTitre(), $film->getRealisateur(), $film->getAnnee(), $film->getPays(), $film->getActeurs(), $film->getGenre(), $film->getSupport(), $film->getDuree(), $film->getSynopsis(), $film->getAffiche(), $film->getBandeAnnonce());
                header('Location: ' . root . '/films.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/films.php');
            } elseif (isset($_GET['id'])) {
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
                $array_duration = $this->formatDuration($duree);
                $synopsis = $row['synopsis'];
                $affiche = $row['affiche'];
                $_SESSION['affiche'] = $affiche;
                $bande_annonce = $row['bande_annonce'];
                $this->render('Films/modification_film', array('effets', 'lightbox'), compact('id', 'titre', 'realisateur', 'annee', 'pays', 'acteurs', 'genre', 'support', 'array_duration', 'synopsis', 'affiche', 'bande_annonce'));
            } else {
                header('Location: ' . root . '/films.php');
            }
        }
    }

    private function formatDuration($duration) {
        $hours = 0;
        $minutes = 0;
        if ($duration) {
            $hours = (int) substr($duration, 0, 2);
            $minutes = (int) substr($duration, 3, 2);
        }
        return array('hours' => $hours, 'minutes' => $minutes);
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_GET['id'])) {
                $id = (int) htmlentities(utf8_decode($_GET['id']));
                $nbDelLines = $this->tableFilm->remove($id);
                $this->checkRemoved($nbDelLines);
            }
            header('Location: ' . root . '/films.php');
        }
    }

    private function checkRemoved($nbDelLines) {
        if ($nbDelLines) {
            $_SESSION['message'] = "Le film a été supprimé avec succès !";
        } else {
            $_SESSION['message'] = "Le film n'a pas pu être supprimé, certainement parce qu'une séance référence encore ce film.";
        }
    }

    public function voter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$MEMBER)) {
            if (isset($_POST['voter'])) {
                $ids = array();
                foreach ($_POST as $post_name => $post_value) {
                    if ($post_name !== 'voter') {
                        $ids[] = (int) $post_value;
                    }
                }
                var_dump($ids);
                //$this->tableFilm->vote($id);
                // Indiquer à l'utilisateur que son vote a bien été pris en compte
            } else {
                $this->render('Films/films');
            }
        }
    }

    private function getInfos($id) {
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
            $etat_affiche = '1';
        }
        switch ($etat_affiche) :
            case '0' : // Affiche non modifiée
                $affiche = $_SESSION['affiche'];
                break;
            case '1' : // Affiche modifiée
                $affiche = $this->uploadFile("Images/Affiches/Films/");
                break;
            case '2' : // Affiche supprimée
                $affiche = null;
                break;
            default :
                die("Etat de l'affiche non autorisé.");
        endswitch;
        $film = new Film($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce);
        return $film;
    }

}

?>
