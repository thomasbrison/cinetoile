<?php

require_once 'Controller.class.php';
require_once 'Editable.interface.php';
require_once 'Beans/Membre.class.php';
require_once 'Tables/TableMembre.php';

class MembresController extends Controller implements Editable {

    private $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

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

    public function ajouter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['ajouter'])) {
            $password = htmlentities(($_POST['login']));
            $membre = $this->getInfos();
            $membre->setPassword($password);
            $this->tableMembre->add($membre);
            header('Location: ' . root . '/membres.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/membres.php');
        } else {
            $this->render('Membres/ajout_membre', array('login'));
        }
    }

    public function modifier() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['modifier'])) {
            $membre = $this->getInfos();
            $this->tableMembre->update($membre);
            header('Location: ' . root . '/membres.php');
        } elseif (isset($_POST['annuler'])) {
            header('Location: ' . root . '/membres.php');
        } elseif (isset($_GET['login'])) {
            $login = htmlentities($_GET['login']);
            $membre = $this->tableMembre->getAttributes($login);
            $this->render('Membres/modification_membre', array('login'), compact('membre'));
        } else {
            header('Location: ' . root . '/membres.php');
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
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        if (isset($_GET['login']) && isset($_GET['droits'])) {
            $login = htmlentities($_GET['login']);
            $droits = htmlentities($_GET['droits']);
            $this->tableMembre->modifyRights($login, $droits);
        }
    }

    public function supprimer() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            return;
        }

        $removed = FALSE;
        $message = "";
        if (isset($_GET['login'])) {
            $login = htmlentities($_GET['login']);
            $nbDelLines = $this->tableMembre->remove($login);
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
            return "Le membre a été supprimé avec succès !";
        } else {
            return "Le membre n'a pas pu être supprimé.";
        }
    }

    private function getInfos() {
        $login = parse_input($_POST['login']);
        $droits = parse_input($_POST['droits']);
        $prenom = parse_input($_POST['prenom']);
        $nom = parse_input($_POST['nom']);
        $email = parse_input($_POST['email']);
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
        $ecole = parse_input($_POST['ecole']);
        $annee = parse_input($_POST['annee']);
        return new Membre($login, null, $droits, $prenom, $nom, $email, $tel, $ecole, $annee);
    }

}
?>
