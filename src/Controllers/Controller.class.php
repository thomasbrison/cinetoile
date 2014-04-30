<?php

require_once 'Lib/Rights.class.php';
require_once 'Lib/functions.php';
require_once 'Lib/files.php';

abstract class Controller {

    /**
     * Start the session.
     * Define default rigths.
     */
    public function __construct() {
        session_start();
        $this->setDefaultSessionRights();
    }

    /**
     * Render a view with the default template.
     * @param string $view Path to the view file without the extension view.php
     * @param array $js_array js files to include
     * @param array $var_array Vars to keep. A key represents the var name
     */
    protected function render($view, array $js_array = array(), array $var_array = null) {
        if ($var_array) {
            extract($var_array);
        }
        include('Layouts/template.php');
    }

    /**
     * Render a view without template.
     * @param string $file_name Path to the view file without the extension view.php
     * @param array $var_array Vars to keep. A key represents the var name
     */
    protected function renderAjax($file_name, array $var_array = null) {
        if ($var_array) {
            extract($var_array);
        }
        include('Views/' . $file_name . '.php');
    }

    /**
     * Default action when the controller is called without method.
     */
    abstract function defaultAction();

    /**
     * Call to a controller with a non existing method
     */
    public function __call($name, $arguments) {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    /**
     * Check if the rights are between a min level and a max level.
     * If not, render a "not authorized" page.
     * @param int $rights Rights to check
     * @param int $levelmin Min level
     * @param int $levelmax Max level
     * @return boolean
     */
    protected function checkRights($rights, $levelmin, $levelmax) {
        if ($rights >= $levelmin && $rights <= $levelmax) {
            return true;
        } else {
            $this->render('autorisations');
            return false;
        }
    }

    /**
     * Set the rights of the session to simple user if rights are not yet defined.
     */
    private function setDefaultSessionRights() {
        if (!isset($_SESSION['droits'])) {
            $_SESSION['droits'] = Rights::$USER;
        }
    }

    /**
     * Upload a file.
     * @param string $form_file_name Name of the form file input
     * @param int $sizemax Max size that the file should be
     * @param array $valid_extensions Array of valid extensions without dot
     * @param string $final_dir Directory where to stock the uploaded file
     * @return string Path to the created file of NULL if there is an error.
     */
    protected function uploadFile($form_file_name, $sizemax, array $valid_extensions, $final_dir) {
        $upload = file_upload($form_file_name, $sizemax, $valid_extensions, $final_dir);
        if ($upload['success']) {
            $path = $final_dir . $upload['file_name'];
        } else {
            $path = NULL;
        }
        if ($upload['error'] !== UPLOAD_ERR_NO_FILE) {
            create_message($upload['message']);
        }
        return $path;
    }

    /**
     * Upload a poster.
     * Form input name must be "affiche".
     * Valid extensions are jpg, jpeg, gif and png.
     * @param string $poster_state
     * @param type $final_dir
     * @return null
     */
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
