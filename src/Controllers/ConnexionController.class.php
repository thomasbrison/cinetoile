<?php

/**
 * Description of ConnexionController
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
class ConnexionController extends Controller {

    /**
     * @var TableMembre
     */
    private $tableMembre;

    public function __construct() {
        parent::__construct();
        $this->tableMembre = new TableMembre();
    }

    public function defaultAction() {
        // Check if the user is already authenticated
        if (isset($this->userLogin)) {
            $this->redirectAlreadyAuthenticated();
            return;
        }
        if (isset($_POST['connexion'])) {
            $this->connectionSubmit();
        } else {
            $this->connectionView();
        }
    }

    private function connectionView() {
        $this->render('authentification');
    }

    private function connectionSubmit() {
        $login = htmlentities(filter_input(INPUT_POST, 'login'));
        $password = htmlentities(filter_input(INPUT_POST, 'password'));
        $rights = $this->tableMembre->authenticate($login, $password);
        if ($rights < Rights::MEMBER) {
            $this->invalidAuthentication();
        } else {
            $this->rememberMember($login, $rights);
            $this->redirectAuthenticated($rights);
        }
    }

    private function rememberMember($login, $rights) {
        $_SESSION['login'] = $login;
        $_SESSION['droits'] = $rights;
    }

    private function invalidAuthentication() {
        create_message("Nom d'utilisateur ou mot de passe incorrect !");
        $this->connectionView();
    }

    private function redirectAuthenticated($rights) {
        if ($rights === Rights::ADMIN) {
            header('Location: ' . Routes::getRoute(Routes::admin));
        } else {
            header('Location: ' . Routes::getRoute(Routes::index));
        }
    }

    private function redirectAlreadyAuthenticated() {
        header('Location: ' . Routes::index);
    }

}
