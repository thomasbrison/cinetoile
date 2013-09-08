<?php

require_once 'Lib/Rights.class.php';

abstract class Controller {

    public function __construct() {
        session_start();
        $this->setRootWebApp();
        $this->setDefaultSessionRights();
        //Exécution de l'action demandée du contrôleur
        $this->executeAction();
    }

    private function root() {
        return dirname(__FILE__) . '/..';
    }

    protected function setRootWebApp() {
        // Définition d'une constante nommée root permettant de reconnaître
        // la racine de l'application. Ceci est pratique dans les vues lors
        // de l'appel de contrôleurs.
        preg_match('@/[^/]+@', $_SERVER["PHP_SELF"], $matches);
        defined('root') || define('root', $matches[0]);  // Cette ligne peut poser problème selon la configuration Apache ; ajouter le nom du dossier si nécessaire
    }

    protected function render($file_name, $js_array = array(), $var_array = null) {
        if ($var_array) {
            extract($var_array);
        }
        include($this->root() . '/Layouts/header.php');
        echo "<section id=\"main\">";
        if (isset($_SESSION['message'])) {
            $this->appendMessage($_SESSION['message']);
            unset($_SESSION['message']);
        }
        require($this->root() . '/Views/' . $file_name . '.view.php');
        echo "</section>";
        include($this->root() . '/Layouts/footer.php');
    }

    protected function renderAjax($file_name, $var_array = null) {
        if ($var_array)
            extract($var_array);
        require($this->root() . '/Views/' . $file_name . '.php');
    }

    abstract function defaultAction();

    private function executeAction() {
        $action = substr(strrchr($_SERVER["PHP_SELF"], "/"), 1);
        if (strpos($action, ".php")) {
            $this->defaultAction();
        } else {
            $this->$action();
        }
    }

    // Appel à un contrôleur avec une action qui n'existe pas
    public function __call($name, $arguments) {
        //echo "<b>Erreur : </b> L'action $name n'est pas d&eacute;finie";
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    protected function checkRights($droits, $levelmin, $levelmax) {
        if ($droits >= $levelmin && $droits <= $levelmax) {
            return true;
        } else {
            $this->render('autorisations');
            return false;
        }
    }

    private function setDefaultSessionRights() {
        if (!isset($_SESSION['droits'])) {
            $_SESSION['droits'] = Rights::$USER;
        }
    }

    protected function uploadFile($final_dir) {
        require_once 'Lib/files.php';
        $sizemax = 100000;
        $valid_extensions = array('jpg', 'jpeg', 'gif', 'png');
        $upload = file_upload('affiche', $sizemax, $valid_extensions, $final_dir);
        $success = $upload['success'];
        $error = $upload['error'];
        $message = $upload['message'];
        if ($success) {
            $affiche = $final_dir . $upload['file_name'];
        } else {
            $affiche = NULL;
        }
        $_SESSION['message'] = $message;
        return $affiche;
    }

    private function appendMessage($message) {
        echo "<p class='message'>$message</p>";
    }

}

?>
