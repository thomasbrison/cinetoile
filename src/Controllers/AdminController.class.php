<?php

class AdminController extends Controller {

    /**
     * @var TableMembre
     */
    private $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function defaultAction() {
        $this->checkUserRights(Rights::ADMIN, Rights::ADMIN);
        $prenom = $this->tableMembre->getFirstName($this->userLogin);
        $this->render('admin', compact('prenom'));
    }

}

?>
