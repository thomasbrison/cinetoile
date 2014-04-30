<?php

/**
 * Description of PresentationController
 *
 * @author thomas.brison@grenoble-inp.org
 */
class PresentationController extends Controller {

    public function defaultAction() {
        $fichier_association = "Ressources/Textes/" . "association.txt";
        $fichier_equipe = "Ressources/Textes/" . "equipe.txt";

        $texte_association = $this->getTextFromFile($fichier_association);
        $texte_equipe = $this->getTextFromFile($fichier_equipe);

        $this->render('presentation', compact('texte_association', 'texte_equipe'));
    }

    private function getTextFromFile($filename) {
        $text = "";
        if (is_file($filename)) {
            $tab_fichier = file($filename);
            $this->readFile($tab_fichier, $text);
        }
        return $text;
    }

    private function readFile(array $file, &$result) {
        if ($file) {
            for ($i = 0; $i < count($file); $i++) {
                $result .= $file[$i];
            }
        }
    }

}

?>
