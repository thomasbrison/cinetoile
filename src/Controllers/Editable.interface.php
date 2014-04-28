<?php

/**
 * Interface to interact with databases
 * @author thomas
 */
interface Editable {

    public function consulter();

    public function ajouter();

    public function modifier();

    public function supprimer();
}

?>
