<?php
/*
 * Vue des diffusions
 */

require_once 'Lib/dates.php';
?>

<section id="main">

    <div class="options">
        <div id="ajout_diffusion">
            <a href="diffusions.php/ajouter">Nouvelle projection</a>
        </div>
    </div>

    <?php
    $array = array_reverse($array);
    foreach ($diffusions as $numero => $diffusion) :
        $numero++;
        $datetime = $diffusion->getDate();
        $dateAndHourArray = format_date($datetime);
        $date = $dateAndHourArray['date'];
        $heure = $dateAndHourArray['heure'];
        $idFilm = $diffusion->getIdFilm();
        $cycle = $diffusion->getCycle();
        $affiche = $diffusion->getAffiche();
        $commentaire = $diffusion->getCommentaire();
        if (isset($tableFilm)) {
            $infosFilm = $tableFilm->getAttributes($idFilm);
            $titre = $infosFilm['titre'];
            $realisateur = $infosFilm['realisateur'];
        }
    
        include 'Templates/diffusion.php';
        
    endforeach; ?>

</section>