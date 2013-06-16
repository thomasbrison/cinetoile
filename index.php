<?php

require_once('def.php');
require_once('Models/user.php');
require_once('Models/film.php');
require_once('Models/diffusion.php');

class indexController extends Controller {

    private $_user;
    private $_film;
    private $_diffusion;

    public function __construct() {
        $this->_user = new User();
        $this->_film = new Film();
        $this->_diffusion = new Diffusion();
        parent::__construct();
    }

    public function defaultAction() {
        $liste_diffusions = $this->_diffusion->consult();
        $films = $this->_film;
        if (isset($_SESSION['login'])) {
            $prenom = $this->_user->getFirstName($_SESSION['login']);
        }
        $js_array = array('index','affiche','video','style');
        $var_array = compact('prenom','liste_diffusions', 'films');
        $this->render('index', $js_array, $var_array);
    }

    public function connexion() {
        // Verifie si l'utilisateur n'etait pas deja connecté
        if (!isset($_SESSION['login'])) {
            $droits = 0;
            if (!isset($_POST['connexion'])) {
                $this->render('authentification');
            } else {
                $login = htmlentities(utf8_decode($_POST['login']));
                $password = htmlentities($_POST['password']);
                $droits = $this->_user->authenticate($login, $password);
                if ($droits == 0) {
                    ?>
                    <script>alert("Nom d'utilisateur ou mot de passe incorrect !");</script>
                    <?php

                    $this->render('authentification');
                } else {
                    $_SESSION['login'] = $login;
                    $_SESSION['droits'] = $droits;
                    if ($_SESSION['droits']==2) {
                        header('Location: ' . root . '/admin.php');
                    } else {
                        header('Location: ' . root . '/index.php');
                    }
                }
            }
        } else {
            $this->defaultAction();
        }
    }

    public function deconnexion() {
        session_destroy();
        header('Location: ' . root . '/index.php/connexion');
    }

}

new indexController();
?>
