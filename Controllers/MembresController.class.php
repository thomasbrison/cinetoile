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
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            $titre_page = "Membres";
            $membres = $this->tableMembre->consult();
            $emailsTab = $this->tableMembre->getEmails();
            $emails = "";
            foreach ($emailsTab as $email) {
                if (strlen($email)) {
                    $emails .= $email . ',';
                }
            }
            $membersEmailsTab = $this->tableMembre->getMembersEmails();
            $membersEmails = "";
            foreach ($membersEmailsTab as $memberEmail) {
                if (strlen($memberEmail)) {
                    $membersEmails .= $memberEmail . ',';
                }
            }
            $this->render('Membres/membres', array('effets'), compact('titre_page', 'membres', 'emails', 'membersEmails'));
        }
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['ajouter'])) {
                $password = htmlentities(($_POST['login']));
                $membre = $this->getInfos();
                $this->tableMembre->add($membre->getLogin(), $password, $membre->getDroits(), $membre->getPrenom(), $membre->getNom(), $membre->getEmail(), $membre->getTelephone(), $membre->getEcole(), $membre->getAnnee());
                header('Location: ' . root . '/membres.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/membres.php');
            } else {
                $this->render('Membres/ajout_membre', array('login'));
            }
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_POST['modifier'])) {
                $membre = $this->getInfos();
                $this->tableMembre->modify($membre->getLogin(), $membre->getDroits(), $membre->getPrenom(), $membre->getNom(), $membre->getEmail(), $membre->getTelephone(), $membre->getEcole(), $membre->getAnnee());
                header('Location: ' . root . '/membres.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/membres.php');
            } elseif (isset($_GET['login'])) {
                $login = htmlentities(utf8_decode($_GET['login']));
                $membre = $this->tableMembre->getAttributes($login);
                $this->render('Membres/modification_membre', array('login'), compact('membre'));
            } else {
                header('Location: ' . root . '/membres.php');
            }
        }
    }

    public function loginExists() {
        $msgUsed = "Le login est déjà utilisé !";
        $msgAvailable = "Le login est disponible !";
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN) AND isset($_GET['login'])) {
            $sth = $this->tableMembre->prepareLogin();
            $row = $this->tableMembre->getLogins($sth, $_GET['login']);
            if (count($row)) {
                echo $msgUsed;
            } else {
                echo $msgAvailable;
            }
        } else {
            echo $msgUsed;
        }
    }

    public function modifierDroits() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_GET['login']) && isset($_GET['droits'])) {
                $login = htmlentities(utf8_decode($_GET['login']));
                $droits = htmlentities($_GET['droits']);
                $this->tableMembre->modifyRights($login, $droits);
            }
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            if (isset($_GET['login'])) {
                $login = htmlentities(utf8_decode($_GET['login']));
                $this->tableMembre->remove($login);
            }
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
