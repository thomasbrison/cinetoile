<?php

require_once('Controller.php');
require_once('Models/Tables/TableUser.php');
require_once('Models/Tables/TableFilm.php');
require_once('Models/Tables/TableDiffusion.php');
require_once('Models/Beans/Diffusion.class.php');

class IndexController extends Controller {

    private $tableUser;
    private $tableFilm;
    private $tableDiffusion;

    public function __construct() {
        $this->tableUser = new TableUser();
        $this->tableFilm = new TableFilm();
        $this->tableDiffusion = new TableDiffusion();
        parent::__construct();
    }

    public function defaultAction() {
        $diffusions = $this->tableDiffusion->consult();
        $table_film = $this->tableFilm;
        if (isset($_SESSION['login'])) {
            $prenom = $this->tableUser->getFirstName($_SESSION['login']);
        }
        $js_array = array('index', 'affiche', 'video', 'style');
        $var_array = compact('prenom', 'diffusions', 'table_film');
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
                $droits = $this->tableUser->authenticate($login, $password);
                if ($droits == 0) {
                    ?>
                    <script>alert("Nom d'utilisateur ou mot de passe incorrect !");</script>
                    <?php

                    $this->render('authentification');
                } else {
                    $_SESSION['login'] = $login;
                    $_SESSION['droits'] = $droits;
                    if ($_SESSION['droits'] == 2) {
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

new IndexController();
?>
