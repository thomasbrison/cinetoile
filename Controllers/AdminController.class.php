<?php

require_once 'Controller.class.php';
require_once 'Tables/TableMembre.php';

class AdminController extends Controller {

    private $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function defaultAction() {
        if ($this->checkRights($_SESSION['droits'], Rights::$ADMIN, Rights::$ADMIN)) {
            $prenom = $this->tableMembre->getFirstName($_SESSION['login']);
            $this->render('admin', array(), compact('prenom'));
        }
    }

}

?>
