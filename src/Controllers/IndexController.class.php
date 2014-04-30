<?php

class IndexController extends Controller {

    /**
     * @var TableMembre
     */
    private $tableMembre;

    /**
     * @var TableFilm
     */
    private $tableFilm;

    /**
     *
     * @var TableDiffusion
     */
    private $tableDiffusion;

    /**
     * @var array
     */
    private $diffusions;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        $this->tableFilm = new TableFilm();
        $this->tableDiffusion = new TableDiffusion();
        parent::__construct();
    }

    public function defaultAction() {
        $table_film = $this->tableFilm;
        $js_array = array('effets', 'pages', 'lightbox', 'facebook');

        if (isset($_SESSION['login'])) {
            $prenom = $this->tableMembre->getFirstName($_SESSION['login']);
        }

        if (isset($_GET['date'])) {
            $diffusion = $this->tableDiffusion->getAttributes($_GET['date']);
            $var_array = compact('diffusion', 'table_film');
            return $this->render('index', $js_array, $var_array);
        }

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = $this->tableDiffusion->pageOfNextDiffusion();
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

}

?>
