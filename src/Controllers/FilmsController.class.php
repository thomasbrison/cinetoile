<?php

require_once 'Controllers/Editable.interface.php';

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
        $this->checkUserRights(Rights::MEMBER, Rights::ADMIN);
        $droits = $this->userRights;
        if ($droits == Rights::ADMIN) {
            $films = $this->tableFilm->consult();
        } else if ($droits == Rights::MEMBER) {
            $films = $this->tableFilm->consultAsAMember();
        }
        $titre_page = "Films";
        $this->render('Films/films', compact('films', 'droits', 'titre_page'));
    }

    public function ajouter() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        if (isset($_POST['ajouter'])) {
            $this->createSubmit();
        } elseif (isset($_POST['annuler'])) {
            $this->createCancel();
        } else {
            $this->createView();
        }
    }

    private function createView() {
        $form_name = "ajout_film";
        $form_action = "ajouter";
        $form_target = Routes::filmsCreate;
        $this->render('Films/formulaire', compact('form_name', 'form_action', 'form_target'));
    }

    private function createSubmit() {
        $film = $this->getInfos(null);
        $this->tableFilm->add($film);
        header('Location: ' . Routes::getRoute(Routes::films));
    }

    private function createCancel() {
        header('Location: ' . Routes::getRoute(Routes::films));
    }

    public function modifier() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        if (isset($_POST['modifier'])) {
            $this->updateSubmit();
        } elseif (isset($_POST['annuler'])) {
            $this->updateCancel();
        } elseif (isset($_GET['id'])) {
            $this->updateView();
        } else {
            $this->updateDefault();
        }
    }

    private function updateView() {
        $id = (int) htmlentities($_GET['id']);
        $film = $this->tableFilm->getAttributes($id);
        $array_duration = $this->arrayDuration($film->getDuree());
        $_SESSION['affiche'] = $film->getAffiche();
        extract($film->arrayInfos());
        $form_name = "modification_film";
        $form_action = "modifier";
        $form_target = Routes::filmsUpdate;
        $this->render('Films/formulaire', compact('id', 'titre', 'realisateur', 'annee', 'pays', 'acteurs', 'genre', 'support', 'array_duration', 'synopsis', 'affiche', 'bande_annonce', 'form_name', 'form_action', 'form_target'));
    }

    private function updateSubmit() {
        $id = (int) htmlentities($_POST['id']);
        $film = $this->getInfos($id);
        $this->tableFilm->update($film);
        header('Location: ' . Routes::getRoute(Routes::films));
    }

    private function updateCancel() {
        header('Location: ' . Routes::getRoute(Routes::films));
    }

    private function updateDefault() {
        $this->updateCancel();
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
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        $removed = FALSE;
        $message = "";
        if (isset($_GET['id'])) {
            $id = (int) htmlentities($_GET['id']);
            $nbDelLines = $this->tableFilm->remove($id);
            $removed = !!$nbDelLines;
            $message = $this->writeRemovedMessage($removed);
        }
        echo json_encode(array("success" => $removed, "message" => $message));
    }

    private function writeRemovedMessage($removed) {
        if ($removed) {
            return "Le film a été supprimé avec succès !";
        } else {
            return "Le film n'a pas pu être supprimé, certainement parce qu'une séance référence encore ce film.";
        }
    }

    public function voter() {
        $this->checkUserRights(Rights::MEMBER, Rights::MEMBER);
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
