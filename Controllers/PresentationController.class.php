<?php

require_once 'Controller.class.php';

/**
 * Description of EquipeController
 *
 * @author thomas
 */
class PresentationController extends Controller  {
    public function defaultAction() {
        $fichier_association = "Ressources/Textes/" . "association.txt";
        $fichier_equipe = "Ressources/Textes/" . "equipe.txt";

        $texte_association = $this->getTextFromFile($fichier_association);
        $texte_equipe = $this->getTextFromFile($fichier_equipe);

        $this->render('presentation', array(), compact('texte_association', 'texte_equipe'));
    }
    
    private function getTextFromFile($filename) {
        $text = "";
        if (is_file($filename)) {
            $tab_fichier = file($filename);
            if ($tab_fichier) {
                for ($i = 0; $i < count($tab_fichier); $i++) {
                    $text .= $tab_fichier[$i];
                }
            }
        }
        return $text;
    }
}

?>
