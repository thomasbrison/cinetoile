<?php

require_once 'Controller.class.php';
require_once 'Editable.interface.php';
require_once 'Beans/Selection.class.php';
require_once 'Beans/Film.class.php';
require_once 'Tables/TableSelection.php';
require_once 'Tables/TableFilm.php';

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
