<?php

require_once 'Controller.class.php';
require_once 'Editable.interface.php';
require_once 'Beans/Vote.class.php';
require_once 'Beans/Film.class.php';
require_once 'Tables/TableVote.php';
require_once 'Tables/TableFilm.php';
require_once 'Tables/TableMembre.php';

/**
 * Description of VoteController
 *
 * @author thomas
 */
class VoteController extends Controller implements Editable {

    private $tableVote;
    private $tableFilm;
    private $tableMembre;

    function __construct() {
        $this->tableVote = new TableVote();
        $this->tableFilm = new TableFilm();
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    public function ajouter() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$MEMBER)) {
            if (isset($_POST['add'])) {
                $this->tableVote->add($$this->parsePost());
                header('Location: ' . root . '/votes.php');
            } elseif (isset($_POST['cancel'])) {
                header('Location: ' . root . '/votes.php');
            } else {
                $this->render('Votes/ajouter');
            }
        }
    }

    public function consulter() {
        $titre_page = "Votes";
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            $votes = $this->tableVote->consult();
            $table_film = $this->tableFilm;
            $table_membre = $this->tableMembre;
            $this->render('Votes/votes', array(), compact('titre_page', 'votes', 'table_film', 'table_membre'));
        }
    }

    public function defaultAction() {
        $this->consulter();
    }

    public function modifier() {
        
    }

    public function supprimer() {
        if ($this->checkRights($_SESSION['droits'], Rights::$MEMBER, Rights::$ADMIN)) {
            $removed = FALSE;
            $message = "";
            if (isset($_GET['id'])) {
                $id = (int) htmlentities(utf8_decode($_GET['id']));
                $nbDelLines = $this->tableVote->remove($id);
                $removed = $this->checkRemoved($nbDelLines);
                $message = $this->writeRemovedMessage($removed);
            }
            echo ((int) $removed) . $message;
        }
    }

    private function checkRemoved($nbDelLines) {
        return (!!$nbDelLines);
    }

    private function writeRemovedMessage($removed) {
        if ($removed) {
            return "Le vote a été supprimé avec succès !";
        } else {
            return "Le vote n'a pas pu être supprimé.";
        }
    }

    private function parsePost() {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $login = isset($_POST['login']) ? $_POST['login'] : $_SESSION['login'];
        $date = $_POST['date'];
        $idFilm = $_POST['id_film'];
        return new Vote($id, $login, $date, $idFilm);
    }

}

?>
