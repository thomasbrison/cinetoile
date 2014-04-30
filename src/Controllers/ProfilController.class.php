<?php

class ProfilController extends AbstractMembreController {

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        $this->checkUserRights(Rights::MEMBER, Rights::ADMIN);
        $membre = $this->tableMembre->getAttributes($this->userLogin);
        $titre_page = "Profil de " . $this->userLogin;
        $this->render('Profil/profil', compact('membre', 'titre_page'));
    }

    public function modifier() {
        $this->checkUserRights(Rights::MEMBER, Rights::ADMIN);
        if (isset($_POST['modifier'])) {
            $this->updateSubmit();
        } elseif (isset($_POST['annuler'])) {
            $this->updateCancel();
        } elseif (isset($this->userLogin)) {
            $this->updateView($this->userLogin, $this->userRights);
        } else {
            $this->updateDefault();
        }
    }

    private function updateView($login, $rights) {
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
        $membre->setLogin($this->userLogin);
        $this->tableMembre->modifyInformation($membre);
        $this->updateSubmitPassword($membre->getLogin(), filter_input(INPUT_POST, 'current_password'));
        header('Location: ' . Routes::getRoute(Routes::profile));
    }

    private function updateSubmitPassword($login, $current_password) {
        if (empty($current_password)) {
            return;
        }
        if ($this->tableMembre->authenticate($login, $current_password) >= Rights::MEMBER) {
            $passwd1 = filter_input(INPUT_POST, 'password1');
            $passwd2 = filter_input(INPUT_POST, 'password2');
            $this->updatePassword($login, $passwd1, $passwd2, "Mot de passe modifié !", "Les mots de passe sont différents. Le mot de passe n'a pas été modifié.");
        } else {
            create_message("Le mot de passe actuel est erroné.");
        }
    }

    private function updateCancel() {
        header('Location: ' . Routes::getRoute(Routes::profile));
    }

    private function updateDefault() {
        $this->updateCancel();
    }

    public function supprimer() {
        $this->checkUserRights(Rights::MEMBER, Rights::ADMIN);
        if (isset($this->userLogin)) {
            $this->tableMembre->remove($this->userLogin);
            session_destroy();
        }
        header('Location: ' . Routes::getRoute(Routes::index));
    }

}

?>
