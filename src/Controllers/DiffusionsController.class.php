<?php

require_once 'Controllers/Editable.interface.php';
require_once 'Beans/Film.class.php';
require_once 'Beans/Diffusion.class.php';
require_once 'Tables/TableFilm.php';
require_once 'Tables/TableDiffusion.php';

class DiffusionsController extends Controller implements Editable {

    private $tableDiffusion;
    private $tableFilm;

    public function __construct() {
        $this->tableDiffusion = new TableDiffusion();
        $this->tableFilm = new TableFilm();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        $diffusions = $this->tableDiffusion->consult();
        $table_film = $this->tableFilm;
        $this->render('Diffusions/diffusions', array('effets'), compact('diffusions', 'table_film'));
    }

    public function ajouter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['ajouter'])) {
            $diffusion = $this->getInfos(null);
            $this->tableDiffusion->add($diffusion);
            header('Location: ' . root . '/diffusions.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/diffusions.php');
        } else {
            $films = $this->tableFilm->consultAsAMember();
            $this->render('Diffusions/ajout_diffusion', array(), compact('films'));
        }
    }

    public function modifier() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['modifier'])) {
            $id = (int) htmlentities($_POST['id']);
            $diffusion = $this->getInfos($id);
            $this->tableDiffusion->update($diffusion);
            header('Location: ' . root . '/diffusions.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/diffusions.php');
        } elseif (isset($_GET['id'])) {
            $diffusion = $this->tableDiffusion->getAttributes((int) $_GET['id']);
            $_SESSION['affiche'] = $diffusion->getAffiche();
            $films = $this->tableFilm->consultAsAMember();
            $this->render('Diffusions/modification_diffusion', array('effets'), compact('diffusion', 'films'));
        } else {
            header('Location: ' . root . '/diffusions.php');
        }
    }

    public function supprimer() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        $removed = FALSE;
        $message = "";
        if (isset($_GET['id'])) {
            $id = (int) htmlentities($_GET['id']);
            $nbDelLines = $this->tableDiffusion->remove($id);
            $removed = $this->checkRemoved($nbDelLines);
            $message = $this->writeRemovedMessage($removed);
        }
        echo json_encode(array(
            "success" => $removed,
            "message" => $message
        ));
    }

    private function checkRemoved($nbDelLines) {
        return (!!$nbDelLines);
    }

    private function writeRemovedMessage($removed) {
        if ($removed) {
            return "La diffusion a été supprimée avec succès !";
        } else {
            return "La diffusion n'a pas pu être supprimée.";
        }
    }

    private function getInfos($id) {
        require_once 'Lib/dates.php';
        $jour = (int) $_POST['jour_diffusion'];
        $mois = (int) $_POST['mois_diffusion'];
        $annee = (int) $_POST['annee_diffusion'];
        $heure = (int) $_POST['heure_diffusion'];
        $minute = (int) $_POST['minute_diffusion'];
        $date = "$annee-$mois-$jour $heure:$minute";
        $id_film = $_POST['id_film'];
        $cycle = parse_input($_POST['cycle']);
        $commentaire = parse_input($_POST['commentaire']);
        $nb_presents = (empty($_POST['nb_presents']) || (int) $_POST['nb_presents'] === -1) ? NULL : (int) $_POST['nb_presents'];
        $datetime = new DateTime($date);
        $year = $datetime->format('Y');
        $month = $datetime->format('m');
        $day = $datetime->format('d');
        $school_years = date_get_school_year($year, $month);
        $str_school_years = $school_years['first_year'] . '-' . $school_years['second_year'];
        $final_dir = "Images/Affiches/Seances/$str_school_years/$month/$day/";
        // On supprime l'affiche du répertoire lorsqu'elle existe et qu'on veut la modifier/supprimer
        if (!$_POST['etat_affiche'] !== '0') {
            foreach (glob($final_dir . '*') as $file) {
                unlink($file);
            }
            rmdir($final_dir);
        }
        $affiche = $this->uploadPoster($_POST['etat_affiche'], $final_dir);
        return new Diffusion($id, $date, $id_film, $cycle, $commentaire, $affiche, $nb_presents);
    }

}

?>
