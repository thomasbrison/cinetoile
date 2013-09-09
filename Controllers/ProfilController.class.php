<?php

require_once 'Controller.class.php';
require_once 'Beans/Membre.class.php';
require_once 'Tables/TableMembre.php';

class ProfilController extends Controller {

    private $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            $membre = $this->tableMembre->getAttributes($_SESSION['login']);
            if (!isset($_SESSION['is_password_changed'])) {
                $_SESSION['is_password_changed'] = false;
            }
            $is_password_changed = $_SESSION['is_password_changed'];
            $titre_page = "Profil de " . $_SESSION['login'];
            $this->render('Profil/profil', array('effets'), compact('membre', 'titre_page', 'is_password_changed'));
        }
    }

    public function modifier() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            if (isset($_POST['modifier'])) {
                $membre = $this->getInfos();
                $membre->setLogin($_SESSION['login']);
                $this->tableMembre->modifyInformation($membre);
                $this->modifyPassword($membre);
                header('Location: ' . root . '/profil.php');
            } elseif (isset($_POST['annuler'])) {
                header('Location: ' . root . '/profil.php');
            } elseif (isset($_SESSION['login'])) {
                $login = $_SESSION['login'];
                $membre = $this->tableMembre->getAttributes($login);
                $this->render('Membres/modification_membre', array(), compact('membre'));
            } else {
                header('Location: ' . root . '/profil.php');
            }
        }
    }

    /**
     * Modify a member's password in the table
     * @param Membre $membre should have a not null login
     */
    private function modifyPassword($membre) {
        if ($membre->getPassword() && strlen($membre->getPassword())) {
            $this->tableMembre->modifyPassword($membre->getLogin(), $membre->getPassword());
            $_SESSION['is_password_changed'] = true;
        }
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            if (isset($_SESSION['login'])) {
                $login = $_SESSION['login'];
                $this->tableMembre->remove($login);
                unset($_SESSION['login']);
                unset($_SESSION['droits']);
            }
            header('Location: ' . root . '/index.php');
        }
    }

    private function getInfos() {
        $login = htmlentities(utf8_decode($_POST['login']));
        $password = htmlentities(utf8_decode($_POST['password']));
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
        $membre = new Membre($login, $password, $droits, $prenom, $nom, $email, $tel, $ecole, $annee);
        return $membre;
    }

}

?>
