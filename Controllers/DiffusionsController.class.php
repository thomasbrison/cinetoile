<?php

require_once 'Controller.class.php';
require_once 'Beans/Film.class.php';
require_once 'Beans/Diffusion.class.php';
require_once 'Tables/TableFilm.php';
require_once 'Tables/TableDiffusion.php';

class DiffusionsController extends Controller {

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
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            $diffusions = $this->tableDiffusion->consult();
            $table_film = $this->tableFilm;
            $this->render('Diffusions/diffusions', array('effets'), compact('diffusions', 'table_film'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['ajouter'])) {
                $jour = $_POST['jour_diffusion'];
                $mois = $_POST['mois_diffusion'];
                $annee = $_POST['annee_diffusion'];
                $heure = $_POST['heure_diffusion'];
                $minute = $_POST['minute_diffusion'];
                $date = "$annee-$mois-$jour $heure:$minute";
                $diffusion = $this->getInfos($date);
                $this->tableDiffusion->add($date, $diffusion->getIdFilm(), $diffusion->getCycle(), $diffusion->getCommentaire(), $diffusion->getAffiche(), $diffusion->getNbPresents());
                header('Location: ' . root . '/diffusions.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/diffusions.php');
            } else {
                $films = $this->tableFilm->consultAsAMember();
                $this->render('Diffusions/ajout_diffusion', array(), compact('films'));
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['modifier'])) {
                $date = $_POST['date'];
                $diffusion = $this->getInfos($date);
                $this->tableDiffusion->modify($date, $diffusion->getIdFilm(), $diffusion->getCycle(), $diffusion->getCommentaire(), $diffusion->getAffiche(), $diffusion->getNbPresents());
                header('Location: ' . root . '/diffusions.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/diffusions.php');
            } elseif (isset($_GET['date'])) {
                $diffusion = $this->tableDiffusion->getAttributes($_GET['date']);
                $_SESSION['affiche'] = $diffusion->getAffiche();
                $films = $this->tableFilm->consultAsAMember();
                $this->render('Diffusions/modification_diffusion', array('effets'), compact('diffusion', 'films'));
            } else {
                header('Location: ' . root . '/diffusions.php');
            }
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_GET['date'])) {
                $date = htmlentities(utf8_decode($_GET['date']));
                $this->tableDiffusion->remove($date);
            }
            header('Location: ' . root . '/diffusions.php');
        }
    }

    private function getInfos($date) {
        $id_film = $_POST['id_film'];
        $cycle = $_POST['cycle'];
        $commentaire = addslashes($_POST['commentaire']);
        $nb_presents = $_POST['nb_presents'];
        $etat_affiche = $_POST['etat_affiche'];
        if (!isset($etat_affiche)) {
            $etat_affiche = "1";
        }
        switch ($etat_affiche) :
            case "0" : // Affiche non modifiée
                $affiche = $_SESSION['affiche'];
                break;
            case "1" : // Affiche modifiée
                require_once 'Lib/files.php';
                $sizemax = 100000;
                $valid_extensions = array('jpg', 'jpeg', 'gif', 'png');
                $final_dir = "Images/Affiches/";
                $upload = file_upload('affiche', $sizemax, $valid_extensions, $final_dir);
                $success = $upload['success'];
                $error = $upload['error'];
                $message = $upload['message'];
                if ($success) {
                    $affiche = $final_dir . $upload['file_name'];
                } elseif ($error == UPLOAD_ERR_NO_FILE) {
                    $affiche = null;
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
        $diffusion = new Diffusion($date, $id_film, $cycle, $commentaire, $affiche, $nb_presents);
        return $diffusion;
    }

}

?>
