<?php

require_once 'Controller.class.php';
require_once 'Editable.interface.php';
require_once 'Beans/Film.class.php';
require_once 'Tables/TableFilm.php';

class FilmsController extends Controller implements Editable {

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
        if (!$this->checkRights($droits, Rights::$MEMBER, Rights::$ADMIN)) {
            return;
        }

        if ($droits == Rights::$ADMIN) {
            $films = $this->tableFilm->consult();
        } else if ($droits == Rights::$MEMBER) {
            $films = $this->tableFilm->consultAsAMember();
        }
        $titre_page = "Films";
        $this->render('Films/films', array('effets', 'lightbox'), compact('films', 'droits', 'titre_page'));
    }

    public function ajouter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['ajouter'])) {
            $film = $this->getInfos(null);
            $this->tableFilm->add($film);
            header('Location: ' . root . '/films.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/films.php');
        } else {
            $this->render('Films/ajout_film');
        }
    }

    public function modifier() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['modifier'])) {
            $id = (int) htmlentities($_POST['id']);
            $film = $this->getInfos($id);
            $this->tableFilm->update($film);
            header('Location: ' . root . '/films.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/films.php');
        } elseif (isset($_GET['id'])) {
            $id = (int) htmlentities($_GET['id']);
            $film = $this->tableFilm->getAttributes($id);
            $array_duration = $this->arrayDuration($film->getDuree());
            $_SESSION['affiche'] = $film->getAffiche();
            extract($film->arrayInfos());
            $this->render('Films/modification_film', array('effets', 'lightbox'), compact('id', 'titre', 'realisateur', 'annee', 'pays', 'acteurs', 'genre', 'support', 'array_duration', 'synopsis', 'affiche', 'bande_annonce'));
        } else {
            header('Location: ' . root . '/films.php');
        }
    }

    private function formatDuration($hours, $minutes) {
        if ($hours != -1 && $minutes != -1) {
            return $hours . ':' . $minutes;
        } else {
            return NULL;
        }
    }

    private function arrayDuration($duration) {
        $hours = NULL;
        $minutes = NULL;
        if ($duration) {
            $hours = (int) substr($duration, 0, 2);
            $minutes = (int) substr($duration, 3, 2);
        }
        return array('hours' => $hours, 'minutes' => $minutes);
    }

    public function supprimer() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        $removed = FALSE;
        $message = "";
        if (isset($_GET['id'])) {
            $id = (int) htmlentities($_GET['id']);
            $nbDelLines = $this->tableFilm->remove($id);
            $removed = $this->checkRemoved($nbDelLines);
            $message = $this->writeRemovedMessage($removed);
        }
        echo ((int) $removed) . $message;
    }

    private function checkRemoved($nbDelLines) {
        return (!!$nbDelLines);
    }

    private function writeRemovedMessage($removed) {
        if ($removed) {
            return "Le film a été supprimé avec succès !";
        } else {
            return "Le film n'a pas pu être supprimé, certainement parce qu'une séance référence encore ce film.";
        }
    }

    public function voter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$MEMBER)) {
            return;
        }

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

    private function getInfos($id) {
        $titre = parse_input($_POST['titre']);
        $realisateur = parse_input($_POST['realisateur']);
        $annee = ((int) $_POST['annee'] === -1) ? NULL : (int) $_POST['annee'];
        $pays = parse_input($_POST['pays']);
        $acteurs = parse_input($_POST['acteurs']);
        $genre = parse_input($_POST['genre']);
        $support = parse_input($_POST['support']);
        $duree = $this->formatDuration((int) $_POST['heures_duree'], (int) $_POST['minutes_duree']);
        $synopsis = parse_input($_POST['synopsis']);
        $bande_annonce = addslashes($_POST['bande_annonce']);
        $affiche = $this->uploadPoster($_POST['etat_affiche'], "Images/Affiches/Films/");
        return new Film($id, $titre, $realisateur, $annee, $pays, $acteurs, $genre, $support, $duree, $synopsis, $affiche, $bande_annonce);
    }

}

?>
