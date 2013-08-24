<?php

require_once 'Controller.class.php';
require_once 'Beans/Diffusion.class.php';
require_once 'Tables/TableMembre.php';
require_once 'Tables/TableFilm.php';
require_once 'Tables/TableDiffusion.php';

class IndexController extends Controller {

    private $tableMembre;
    private $tableFilm;
    private $tableDiffusion;
    private $diffusions;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        $this->tableFilm = new TableFilm();
        $this->tableDiffusion = new TableDiffusion();
        parent::__construct();
    }

    public function defaultAction() {
        $table_film = $this->tableFilm;
        $js_array = array('index', 'affiche', 'video', 'style', 'ajax', 'lightbox', 'facebook');

        if (isset($_SESSION['login'])) {
            $prenom = $this->tableMembre->getFirstName($_SESSION['login']);
        }
        
        if (isset ($_GET['date'])) {
            $diffusion = $this->tableDiffusion->getAttributes($_GET['date']);
            $var_array = compact('diffusion', 'table_film');
            return $this->render('index', $js_array, $var_array);
        }

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 0;
        }
        
        if (!$this->diffusions) {
            $reverse_diffusions = $this->tableDiffusion->consult();
            $this->diffusions = array_reverse($reverse_diffusions);
        }
        $nb_pages = count($this->diffusions);
	if ($nb_pages) {
	    $diffusion = $this->diffusions[$page];
	} else {
	    return $this->render('no-diffusion');
	}
        
        if (isset($_GET['isajax']) && (int) $_GET['isajax'] == 1) {
            $var_array = compact('diffusion', 'table_film', 'page', 'nb_pages');
            $this->renderAjax('Templates/seance', $var_array);
        } else {
            $var_array = compact('prenom', 'diffusion', 'table_film', 'page', 'nb_pages');
            $this->render('index', $js_array, $var_array);
        }
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
                $droits = $this->tableMembre->authenticate($login, $password);
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
?>
