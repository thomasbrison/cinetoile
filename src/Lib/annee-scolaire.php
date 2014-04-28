<?php

function annee_format($annee) {
    return ($annee && $annee != "Autre") ? $annee . "A" : $annee;
}

?>
