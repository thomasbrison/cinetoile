<?php
/*
 * Vue des diffusions
 */

require_once 'Lib/dates.php';
?>

<div class="options">
    <a class="button" href="diffusions.php/ajouter">Nouvelle projection</a>
</div>

<?php
$diffusions = array_reverse($diffusions);
foreach ($diffusions as $numero => $diffusion) :
    $numero++;
    $datetime = $diffusion->getDate();
    $date_and_hour_array = date_format_to_string($datetime);
    $date = $date_and_hour_array['date'];
    $heure = $date_and_hour_array['heure'];
    $id_film = $diffusion->getIdFilm();
    $cycle = $diffusion->getCycle();
    $affiche = $diffusion->getAffiche();
    $commentaire = $diffusion->getCommentaire();
    if (isset($table_film)) {
        $infos_film = $table_film->getAttributes($id_film);
        $titre = $infos_film['titre'];
        $realisateur = $infos_film['realisateur'];
    }

    include 'Templates/diffusion.php';

endforeach;
?>