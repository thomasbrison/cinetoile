<?php

require_once 'Controllers/Editable.interface.php';

class MembresController extends AbstractMembreController implements Editable {

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        $titre_page = "Membres";
        $membres = $this->tableMembre->consult();
        $emails = $this->getAllEmails();
        $membersEmails = $this->getMembersEmails();
        $this->render('Membres/membres', compact('titre_page', 'membres', 'emails', 'membersEmails'));
    }

    private function getAllEmails() {
        $emailsTab = $this->tableMembre->getEmails();
        $emails = "";
        foreach ($emailsTab as $email) {
            if (strlen($email)) {
                $emails .= $email . ',';
            }
        }
        return $emails;
    }

    private function getMembersEmails() {
        $membersEmailsTab = $this->tableMembre->getMembersEmails();
        $membersEmails = "";
        foreach ($membersEmailsTab as $memberEmail) {
            if (strlen($memberEmail)) {
                $membersEmails .= $memberEmail . ',';
            }
        }
        return $membersEmails;
    }

    public function ajouter() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        if (isset($_POST['ajouter'])) {
            $this->createSubmit();
        } elseif (isset($_POST['annuler'])) {
            $this->createCancel();
        } else {
            $this->createView($this->userRights);
        }
    }

    private function createView($rights) {
        $form_name = "ajout_membre";
        $form_action = "ajouter";
        $form_base = Routes::members;
        $form_target = Routes::membersCreate;
        $infos_principales_view = $rights === Rights::ADMIN ? 'infos_principales_admin.view.php' : 'infos_principales_membre.view.php';
        $this->render('Membres/formulaire', compact('form_name', 'form_action', 'form_base', 'form_target', 'infos_principales_view'));
    }

    private function createSubmit() {
        $password = htmlentities($_POST['login']);
        $membre = $this->parseInputs($_POST);
        $membre->setPassword($password);
        $this->tableMembre->add($membre);
        header('Location: ' . Routes::getRoute(Routes::members));
    }

    private function createCancel() {
        header('Location: ' . Routes::getRoute(Routes::members));
    }

    public function modifier() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        if (isset($_POST['modifier'])) {
            $this->updateSubmit();
        } elseif (isset($_POST['annuler'])) {
            $this->updateCancel();
        } elseif (isset($_GET['login'])) {
            $this->updateView($this->userRights);
        } else {
            $this->updateDefault();
        }
    }

    private function updateView($rights) {
        $login = htmlentities($_GET['login']);
        $membre = $this->tableMembre->getAttributes($login);
        $form_name = "modification_membre";
        $form_action = "modifier";
        $form_base = $rights === Rights::MEMBER ? Routes::profile : Routes::members;
        $form_target = $rights === Rights::MEMBER ? Routes::profileUpdate : Routes::membersUpdate;
        $infos_principales_view = $rights === Rights::ADMIN ? 'infos_principales_admin.view.php' : 'infos_principales_membre.view.php';
        $this->render('Membres/formulaire', compact('membre', 'form_name', 'form_action', 'form_base', 'form_target', 'infos_principales_view'));
    }

    private function updateSubmit() {
        $membre = $this->parseInputs($_POST);
        $this->tableMembre->update($membre);
        $this->updatePassword($membre->getLogin(), $_POST['password1'], $_POST['password2'], "Mot de passe modifié !", "Les mots de passe sont différents. Le mot de passe n'a pas été modifié.");
        header('Location: ' . Routes::getRoute(Routes::members));
    }

    private function updateCancel() {
        header('Location: ' . Routes::getRoute(Routes::members));
    }

    private function updateDefault() {
        $this->updateCancel();
    }

    public function loginExists() {
        $msgUsed = "Le login est déjà utilisé !";
        $msgAvailable = "Le login est disponible !";
        if ($this->checkRights($this->userRights, Rights::MEMBER, Rights::ADMIN) AND isset($_GET['login'])) {
            $row = $this->tableMembre->getLogins($_GET['login']);
            if (!count($row)) {
                echo $msgAvailable;
                return;
            }
        }
        echo $msgUsed;
    }

    public function modifierDroits() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        if (isset($_GET['login']) && isset($_GET['droits'])) {
            $login = htmlentities($_GET['login']);
            $droits = htmlentities($_GET['droits']);
            $this->tableMembre->modifyRights($login, $droits);
        }
    }

    public function supprimer() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        $removed = FALSE;
        $message = "";
        if (isset($_GET['login'])) {
            $login = htmlentities($_GET['login']);
            $nbDelLines = $this->tableMembre->remove($login);
            $removed = !!$nbDelLines;
            $message = $this->writeRemovedMessage($removed);
        }
        echo json_encode(array("success" => $removed, "message" => $message));
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
