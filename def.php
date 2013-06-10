<?php
abstract class Controller {

    private function root() {
        return dirname(__FILE__);
    }
        
    protected function setRootWebApp(){
        // Définition d'une constante nommée root permettant de reconnaître
        // la racine de l'application. Ceci est pratique dans les vues lors
        // de l'appel de contrôleurs.
        preg_match('@/[^/]+@', $_SERVER["PHP_SELF"], $matches);
        defined('root') || define('root', $matches[0]);
    }
    
    protected function render($file_name, $js_array=null, $var_array = null) {
        if ($var_array)
           extract($var_array);
        include($this->root() . '/Layouts/header.php');
        require($this->root() . '/Views/' . $file_name . '.view.php');
        include($this->root() . '/Layouts/footer.php');
    }
    
//    protected function constructController($file_name,$controllerName) {
//        require(root . '/' . $file_name . '.php');
//        //$this->render($file_name);
//        $controller=new $controllerName();
//        $controller->defaultAction();
//    }

    abstract function defaultAction() ;

    private function executeAction(){
        $action = substr(strrchr($_SERVER["PHP_SELF"], "/"), 1);
        if (strpos($action, ".php")) {
            $this->defaultAction();
        } else {
            $this->$action() ;       
        }
    }

    // Appel à un contrôleur avec une action qui n'existe pas
    private function __call($name, $arguments){
        echo "<b>Erreur : </b> L'action $name n'est pas d&eacute;finie" ;
    }

    public function __construct() {
        session_start();
        $this->setRootWebApp() ;        
        //Exécution de l'action demandée du contrôleur
        $this->executeAction() ;   
    }
    
    public function checkRights($droits, $levelmin, $levelmax) {
        if ($droits >= $levelmin && $droits <= $levelmax) {
            return true;
        } else {
            $this->render('autorisations');
            return false;
        }
    }

    protected function upload_file($file, $sizemax, $extensions_valides, $final_dir) {
        $final_dir = "/var/www" . root . "/" . $final_dir;
        $envoi_ok = false;
        $array_file = $_FILES[$file];
        $file_name = $array_file['name'];
        $file_name = strtr($file_name, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $file_name = preg_replace('/([^.-a-z0-9]+)/i', '_', $file_name);
        if (isset($array_file) AND $array_file['error'] == 0) {
            $taille = filesize($array_file['tmp_name']);
            if ($taille <= $sizemax) {
                $infos_fichier = pathinfo($array_file['name']);
                $extension_upload = $infos_fichier['extension'];
                if (in_array($extension_upload, $extensions_valides)) {
                    if (file_exists($final_dir.$file_name)) {
                        $envoi_ok = true;
                    } else {
                        $envoi_ok = move_uploaded_file($array_file['tmp_name'], $final_dir.$file_name);
                    }
                    if ($envoi_ok) {
                        $message = "L'envoi du fichier $file_name a bien été effectué !";
                    } else {
                        $message = "Erreur lors de l'écriture du fichier $file_name. Le répertoire $final_dir n'est peut-être pas libre en écriture.";
                    }
                } else {
                    $message = "Extension $extension_upload non autorisée.";
                }
            } else {
                $message = "Envoi limité à 1Mo.";
            }
        } else {
            $message = "Erreur lors de l'envoi du fichier $file_name : ";
            switch ($array_file['error']) {
                case UPLOAD_ERR_INI_SIZE :   // 1
                    $message += "le fichier dépasse la limite autorisée par le serveur.";
                    break;
                case UPLOAD_ERR_FORM_SIZE :   // 2
                    $message += "le fichier dépasse la limite autorisée dans le formulaire.";
                    break;
                case UPLOAD_ERR_PARTIAL :   // 3
                    $message += "l'envoi du fichier a été interrompu pendant le transfert.";
                    break;
                case UPLOAD_ERR_NO_FILE :   // 4
                    $message += "le fichier a une taille nulle.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR :    // 6
                    $message += "absence de répertoire temporaire.";
                    break;
                case UPLOAD_ERR_CANT_WRITE :   // 7
                    $message += "écriture impossible.";
                    break;
                case UPLOAD_ERR_EXTENSION :   // 8
                    $message += "mauvaise extension.";
                    break;
            }
        }
        $upload = array(
            'success' => $envoi_ok,
            'message' => utf8_decode($message),
            'file_name' => $file_name
        );
        return $upload;
    }

}
?>
