<?php

require_once 'AbstractMembreController.class.php';
require_once 'Editable.interface.php';

class MembresController extends AbstractMembreController implements Editable {

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
            $membre = $this->parseInputs($_POST);
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
            $membre = $this->parseInputs($_POST);
            $this->tableMembre->update($membre);
            $this->updatePassword($membre->getLogin(), $_POST['password1'], $_POST['password2'], "Mot de passe modifié !", "Les mots de passe sont différents. Le mot de passe n'a pas été modifié.");
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
            return "Le membre a été supprimé avec succès !";
        } else {
            return "Le membre n'a pas pu être supprimé.";
        }
    }

}
?>
