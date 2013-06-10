<?php

/*
 * Controlleur des diffusions
 */

require_once('def.php');
require_once('Models/film.php');
require_once('Models/diffusion.php');

class diffusionsController extends Controller {
    
    private $_diffusion;
    private $_film;
    
    public function __construct() {
        $this->_diffusion = new Diffusion();
        $this->_film = new Film();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $array = $this->_diffusion->consult();
            $films = $this->_film;
            $this->render('diffusions', array('index', 'style'), compact('array', 'films'));
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
                $this->_diffusion->add($date, $id_film, $cycle, $commentaire, $affiche);
                header('Location: ' . root . '/diffusions.php');
            } else {
                $liste_films= $this->_film->consultAsAMember();
                $this->render('ajout_diffusion', array(), compact('liste_films'));
            }
        }
    }
    
    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['modifier'])) {
                $date = $_POST['date'];
                $vars = $this->getInfos();
                extract($vars);
                $this->_diffusion->modify($date, $id_film, $cycle, $commentaire, $affiche);
                header('Location: ' . root . '/diffusions.php');
            } elseif (isset($_GET['modifier_diffusion'])) {
                $date = $_GET['date'];
                $row = $this->_diffusion->getAttributes($date);
                $id_film = $row['id_film'];
                $cycle = $row['cycle'];
                $commentaire = $row['commentaire'];
                $affiche = $row['affiche'];
                $_SESSION['affiche'] = $affiche;
                $liste_films = $this->_film->consultAsAMember();
                $this->render('modification_diffusion', array('style'), 
                        compact('date', 'id_film', 'cycle', 'commentaire', 'affiche', 'liste_films'));
            } else {
                header('Location: ' . root . '/diffusions.php');
            }
        }
    }
    
    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_GET['supprimer'])) {
                $date = htmlentities(utf8_decode($_GET['date']));
                $this->_diffusion->remove($date);
                header('Location: ' . root . '/diffusions.php');
            } else {
                $this->render('diffusions');
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
                $sizemax = 100000;
                $extensions_valides = array('jpg','jpeg','gif','png');
                $final_dir = "Images/Affiches/";
                $upload = $this->upload_file('affiche', $sizemax, $extensions_valides, $final_dir);
                $envoi_ok = $upload['success'];
                $message = $upload['message'];
                if ($envoi_ok) {
                    $affiche = $final_dir.$upload['file_name'];
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
