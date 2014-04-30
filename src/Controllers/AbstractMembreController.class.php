<?php

/**
 * Common controller AbstractMembreController for MembresController and ProfilController
 *
 * @author thomas.brison@grenoble-inp.org
 */
abstract class AbstractMembreController extends Controller {

    /**
     * @var TableMembre
     */
    protected $tableMembre;

    public function __construct() {
        $this->tableMembre = new TableMembre();
        parent::__construct();
    }

    /**
     * Parse an array containing values 'tel1', 'tel2', 'tel3', 'tel4' and 'tel5'.
     * If all of these values are set, return the string, else return null.
     * @param array $array
     * @return string
     */
    private function parseTel(array $array) {
        $tel1 = htmlentities($array['tel1']);
        $tel2 = htmlentities($array['tel2']);
        $tel3 = htmlentities($array['tel3']);
        $tel4 = htmlentities($array['tel4']);
        $tel5 = htmlentities($array['tel5']);
        if ($tel1 AND $tel2 AND $tel3 AND $tel4 AND $tel5) {
            return "$tel1$tel2$tel3$tel4$tel5";
        }
        return NULL;
    }

    /**
     * Parse an array of inputs to create a new Membre bean.
     * @param array $array inputs
     * @return \Membre
     */
    protected function parseInputs(array $array) {
        $login = parse_input($array['login']);
        $droits = parse_input($array['droits']);
        $prenom = parse_input($array['prenom']);
        $nom = parse_input($array['nom']);
        $email = parse_input($array['email']);
        $tel = $this->parseTel($array);
        $ecole = parse_input($array['ecole']);
        $annee = parse_input($array['annee']);
        return new Membre($login, NULL, $droits, $prenom, $nom, $email, $tel, $ecole, $annee);
    }

    /**
     * Update the password of a member if the fields are set.
     * @param string $login
     * @param string $password1
     * @param string $password2
     * @param string $successMessage
     * @param string $notSamePasswordMessage
     * @return bool True if the password has been changed.
     */
    final protected function updatePassword($login, $password1, $password2, $successMessage, $notSamePasswordMessage) {
        if (!empty($password1) && !empty($password2)) {
            if ($password1 === $password2) {
                $this->tableMembre->modifyPassword($login, parse_input($password1));
                create_message($successMessage);
                return true;
            }
            create_message($notSamePasswordMessage);
        }
        return false;
    }

}
