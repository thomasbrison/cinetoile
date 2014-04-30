<?php

require_once 'Controllers/Editable.interface.php';

/**
 * Description of SelectionController
 *
 * @author thomas
 */
class SelectionController extends Controller implements Editable {
    
    private $tableSelection;
    private $tableFilm;

    function __construct() {
        $this->tableSelection = new TableSelection();
        $this->tableFilm = new TableFilm();
        parent::__construct();
    }
    
    public function ajouter() {
        
    }

    public function consulter() {
        
    }

    public function defaultAction() {
        
    }

    public function modifier() {
        
    }

    public function supprimer() {
        
    }
}

?>
