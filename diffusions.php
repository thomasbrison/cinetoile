<?php

/*
 * Controlleur des diffusions
 */

require_once('def.php');
require_once('Models/Tables/TableFilm.php');
require_once('Models/Tables/TableDiffusion.php');
require_once('Models/Beans/Film.class.php');
require_once('Models/Beans/Diffusion.class.php');

class diffusionsController extends Controller {

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
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $diffusions = $this->tableDiffusion->consult();
            $tableFilm = $this->tableFilm;
            $this->render('Diffusions/diffusions', array('index', 'style'), compact('diffusions', 'tableFilm'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['ajouter'])) {
                $jour = $_POST['jour_diffusion'];
                $mois = $_POST['mois_diffusion'];
                $annee = $_POST['annee_diffusion'];
                $heure = $_POST['heure_diffusion'];
                $minute = $_POST['minute_diffusion'];
                $date = "$annee-$mois-$jour $heure:$minute";
                $vars = $this->getInfos();
                extract($vars);
                $this->tableDiffusion->add($date, $id_film, $cycle, $commentaire, $affiche);
                header('Location: ' . root . '/diffusions.php');
            } else {
                $films = $this->tableFilm->consultAsAMember();
                $this->render('Diffusions/ajout_diffusion', array(), compact('films'));
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['modifier'])) {
                $date = $_POST['date'];
                $vars = $this->getInfos();
                extract($vars);
                $this->tableDiffusion->modify($date, $id_film, $cycle, $commentaire, $affiche);
                header('Location: ' . root . '/diffusions.php');
            } elseif (isset($_GET['modifier_diffusion'])) {
                $date = $_GET['date'];
                $row = $this->tableDiffusion->getAttributes($date);
                $id_film = $row['id_film'];
                $cycle = $row['cycle'];
                $commentaire = $row['commentaire'];
                $affiche = $row['affiche'];
                $_SESSION['affiche'] = $affiche;
                $films = $this->tableFilm->consultAsAMember();
                $this->render('Diffusions/modification_diffusion', array('style'), compact('date', 'id_film', 'cycle', 'commentaire', 'affiche', 'films'));
            } else {
                header('Location: ' . root . '/diffusions.php');
            }
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_GET['supprimer'])) {
                $date = htmlentities(utf8_decode($_GET['date']));
                $this->tableDiffusion->remove($date);
                header('Location: ' . root . '/diffusions.php');
            } else {
                $this->render('Diffusions/diffusions');
            }
        }
    }

    private function getInfos() {
        $id_film = $_POST['id_film'];
        $cycle = $_POST['cycle'];
        $commentaire = addslashes($_POST['commentaire']);
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
        $var_array = compact('id_film', 'cycle', 'commentaire', 'affiche', 'liste_films');
        return $var_array;
    }

}

new diffusionsController();
?>
