<?php

require_once 'Controllers/AbstractMembreController.class.php';

class ProfilController extends AbstractMembreController {

    public function defaultAction() {
        $this->consulter();
    }

    public function consulter() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            return;
        }

        $membre = $this->tableMembre->getAttributes($_SESSION['login']);
        $titre_page = "Profil de " . $_SESSION['login'];
        $this->render('Profil/profil', array('effets'), compact('membre', 'titre_page'));
    }

    public function modifier() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            return;
        }

        if (isset($_POST['modifier'])) {
            $membre = $this->parseInputs($_POST);
            $membre->setLogin($_SESSION['login']);
            $this->tableMembre->modifyInformation($membre);
            $login = $membre->getLogin();
            $current_passwd = $_POST['current_password'];
            if (!empty($current_passwd)) {
                if ($this->tableMembre->authenticate($login, $current_passwd) >= Rights::$MEMBER) {
                    $this->updatePassword($login, $_POST['password1'], $_POST['password2'], "Mot de passe modifié !", "Les mots de passe sont différents. Le mot de passe n'a pas été modifié.");
                } else {
                    create_message("Le mot de passe actuel est erroné.");
                }
            }
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

    public function supprimer() {
        if (!$this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            return;
        }

        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $this->tableMembre->remove($login);
            unset($_SESSION['login']);
            unset($_SESSION['droits']);
        }
        header('Location: ' . root . '/index.php');
    }

}

?>
