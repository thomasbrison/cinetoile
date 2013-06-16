<?php

require_once('def.php');
require_once('Models/Tables/TableUser.php');

class adminController extends Controller {

    private $tableUser;

    public function __construct() {
        $this->tableUser = new TableUser();
        parent::__construct();
    }

    public function defaultAction() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $prenom = $this->tableUser->getFirstName($_SESSION['login']);
            $this->render('admin', array('index'), compact('prenom'));
        }
    }

}

new adminController();
?>

