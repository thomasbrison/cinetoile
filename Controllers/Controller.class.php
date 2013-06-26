<?php

abstract class Controller {

    public function __construct() {
        session_start();
        $this->setRootWebApp();
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
        defined('root') || define('root', $matches[0]);
    }

    protected function render($file_name, $js_array = null, $var_array = null) {
        if ($var_array)
            extract($var_array);
        include($this->root() . '/Layouts/header.php');
        require($this->root() . '/Views/' . $file_name . '.view.php');
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
    private function __call($name, $arguments) {
        echo "<b>Erreur : </b> L'action $name n'est pas d&eacute;finie";
    }

    protected function checkRights($droits, $levelmin, $levelmax) {
        if ($droits >= $levelmin && $droits <= $levelmax) {
            return true;
        } else {
            $this->render('autorisations');
            return false;
        }
    }

}

?>
