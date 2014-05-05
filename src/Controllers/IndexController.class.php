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
        if (isset($_GET['id'])) {
            $this->displaySingleDiffusion($_GET['id']);
        } else {
            $this->displayAllDiffusions();
        }
    }

    private function displaySingleDiffusion($id) {
        $table_film = $this->tableFilm;
        $diffusion = $this->tableDiffusion->getAttributes($id);
        $this->render('index', compact('diffusion', 'table_film'));
    }

    private function displayAllDiffusions() {
        $this->setDiffusions();
        $page = $this->getCurrentPage();
        $nb_pages = count($this->diffusions);
        $diffusion = $this->getDiffusion($page, $nb_pages);
        if ($diffusion) {
            $this->renderDiffusion($diffusion, $page, $nb_pages);
        } else {
            $this->render('no-diffusion');
        }
    }

    private function getCurrentPage() {
        if (isset($_GET['page'])) {
            return $_GET['page'];
        }
        return $this->tableDiffusion->pageOfNextDiffusion();
    }

    private function setDiffusions() {
        if (!$this->diffusions) {
            $reverse_diffusions = $this->tableDiffusion->consult();
            $this->diffusions = array_reverse($reverse_diffusions);
        }
    }

    private function getDiffusion($page, $nb_pages) {
        if ($page >= 0 && $page < $nb_pages) {
            return $this->diffusions[$page];
        }
        return NULL;
    }

    private function renderDiffusion($diffusion, $page, $nb_pages) {
        $table_film = $this->tableFilm;
        if (isset($_GET['isajax']) && (int) $_GET['isajax'] == 1) {
            $this->renderAjax('Templates/seance', compact('diffusion', 'table_film', 'page', 'nb_pages'));
        } else {
            if (isset($this->userLogin)) {
                $prenom = $this->tableMembre->getFirstName($this->userLogin);
            }
            $this->render('index', compact('prenom', 'diffusion', 'table_film', 'page', 'nb_pages'));
        }
    }

}

?>
