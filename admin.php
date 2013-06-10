<?php

require_once('def.php');
require_once('Models/user.php');

class adminController extends Controller {

    private $_user;

    public function __construct() {
        $this->_user = new User();
        parent::__construct();
    }

    public function defaultAction() {
        if ($this->checkRights($_SESSION['droits'], 2, 2)) {
            $prenom=$this->_user->getFirstName($_SESSION['login']);
            $this->render('admin', array('index'), compact('prenom'));
        }
    }

}

new adminController();
?>

