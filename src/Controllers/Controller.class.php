<?php

require_once 'Lib/Rights.class.php';
require_once 'Lib/Routes.class.php';
require_once 'Lib/functions.php';

abstract class Controller {

    public function __construct() {
        session_start();
        $this->setDefaultSessionRights();
    }

    private function root() {
        return dirname(__FILE__) . '/..';
    }

    protected function render($view, $js_array = array(), $var_array = null) {
        if ($var_array) {
            extract($var_array);
        }
        include($this->root() . '/Layouts/template.php');
    }

    protected function renderAjax($file_name, $var_array = null) {
        if ($var_array)
            extract($var_array);
        require($this->root() . '/Views/' . $file_name . '.php');
    }

    abstract function defaultAction();

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

    protected function uploadFile($form_file_name, $sizemax, $valid_extensions, $final_dir) {
        require_once 'Lib/files.php';
        $upload = file_upload($form_file_name, $sizemax, $valid_extensions, $final_dir);
        $success = $upload['success'];
        $error = $upload['error'];
        $message = $upload['message'];
        if ($success) {
            $path = $final_dir . $upload['file_name'];
        } else {
            $path = NULL;
        }
        if ($error !== UPLOAD_ERR_NO_FILE) {
            create_message($message);
        }
        return $path;
    }

    protected function uploadPoster($poster_state, $final_dir) {
        if (!isset($poster_state)) {
            $poster_state = '1';
        }
        switch ($poster_state) :
            case '0' : // Affiche non modifiée
                $poster_path = $_SESSION['affiche'];
                break;
            case '1' : // Affiche modifiée
                $poster_path = $this->uploadFile('affiche', 100000, array('jpg', 'jpeg', 'gif', 'png'), $final_dir);
                break;
            case '2' : // Affiche supprimée
                $poster_path = NULL;
                break;
            default :
                die("Etat de l'affiche non autorisé.");
        endswitch;
        return $poster_path;
    }

}

?>
