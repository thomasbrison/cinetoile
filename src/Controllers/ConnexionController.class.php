<?php

/**
 * Description of Connexion
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
        // Verifie si l'utilisateur n'etait pas deja connecté
        if (!isset($this->userLogin)) {
            $droits = Rights::USER;
            if (!isset($_POST['connexion'])) {
                $this->render('authentification');
            } else {
                $login = htmlentities($_POST['login']);
                $password = htmlentities($_POST['password']);
                $droits = $this->tableMembre->authenticate($login, $password);
                if ($droits < Rights::MEMBER) {
                    create_message("Nom d'utilisateur ou mot de passe incorrect !");
                    $this->render('authentification');
                } else {
                    $_SESSION['login'] = $login;
                    $_SESSION['droits'] = $droits;
                    if ($_SESSION['droits'] === Rights::ADMIN) {
                        header('Location: ' . Routes::getRoute(Routes::admin));
                    } else {
                        header('Location: ' . Routes::getRoute(Routes::index));
                    }
                }
            }
        } else {
            $this->defaultAction();
        }
    }

}
