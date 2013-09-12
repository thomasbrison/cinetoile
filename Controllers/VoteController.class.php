<?php

require_once 'Controller.class.php';
require_once 'Editable.interface.php';
require_once 'Beans/Vote.class.php';
require_once 'Beans/Film.class.php';
require_once 'Tables/TableVote.php';
require_once 'Tables/TableFilm.php';

/**
 * Description of VoteController
 *
 * @author thomas
 */
class VoteController extends Controller implements Editable {

    private $tableVote;
    private $tableFilm;

    function __construct() {
        $this->tableVote = new TableVote();
        $this->tableFilm = new TableFilm();
        parent::__construct();
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$MEMBER)) {
            
        }
    }

    public function consulter() {
        
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function modifier() {
        
    }

    public function supprimer() {
        
    }

}

?>
