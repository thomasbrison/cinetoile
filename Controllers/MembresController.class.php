<?php

require_once 'Controller.class.php';
require_once 'Beans/Membre.class.php';
require_once 'Tables/TableMembre.php';

class MembresController extends Controller {

    private $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $titre_page = "Membres";
            $membres = $this->tableMembre->consult();
            $emailsTab = $this->tableMembre->getEmails();
            $emails = "";
            foreach ($emailsTab as $email) {
                if (strlen($email)) {
                    $emails .= $email . ',';
                }
            }
            $this->render('Membres/membres', array('index', 'style'), compact('titre_page', 'membres', 'emails'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['ajouter'])) {
                $password = htmlentities(($_POST['password']));
                $membre = $this->getInfos();
                $this->tableMembre->add($membre->getLogin(), $password, $membre->getDroits(), $membre->getPrenom(), $membre->getNom(), $membre->getEmail(), $membre->getTelephone(), $membre->getEcole(), $membre->getAnnee());
                header('Location: ' . root . '/membres.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/membres.php');
            } else {
                $this->render('Membres/ajout_membre');
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            if (isset($_POST['modifier'])) {
                $membre = $this->getInfos();
                $this->tableMembre->modify($membre->getLogin(), $membre->getDroits(), $membre->getPrenom(), $membre->getNom(), $membre->getEmail(), $membre->getTelephone(), $membre->getEcole(), $membre->getAnnee());
                header('Location: ' . root . '/membres.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/membres.php');
            } else {
                $login = htmlentities(utf8_decode($_GET['login']));
                $membre = $this->tableMembre->getAttributes($login);
                $this->render('Membres/modification_membre', array(), compact('membre'));
            }
        }
    }

    public function modifierDroits() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $login = htmlentities(utf8_decode($_GET['login']));
            $droits = htmlentities($_GET['droits']);
            $this->tableMembre->modifyRights($login, $droits);
            header('Location: ' . root . '/membres.php');
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $login = htmlentities(utf8_decode($_GET['login']));
            $this->tableMembre->remove($login);
            header('Location: ' . root . '/membres.php');
        }
    }

    private function getInfos() {
        $login = htmlentities(utf8_decode($_POST['login']));
        $droits = htmlentities($_POST['droits']);
        $prenom = htmlentities(utf8_decode($_POST['prenom']));
        $nom = htmlentities(utf8_decode($_POST['nom']));
        $email = htmlentities($_POST['email']);
        $tel1 = htmlentities($_POST['tel1']);
        $tel2 = htmlentities($_POST['tel2']);
        $tel3 = htmlentities($_POST['tel3']);
        $tel4 = htmlentities($_POST['tel4']);
        $tel5 = htmlentities($_POST['tel5']);
        if ($tel1 AND $tel2 AND $tel3 AND $tel4 AND $tel5) {
            $tel = "$tel1$tel2$tel3$tel4$tel5";
        } else {
            $tel = null;
        }
        $ecole = htmlentities($_POST['ecole']);
        $annee = htmlentities($_POST['annee']);
        $membre = new Membre($login, null, $droits, $prenom, $nom, $email, $tel, $ecole, $annee);
        return $membre;
    }

}

?>
