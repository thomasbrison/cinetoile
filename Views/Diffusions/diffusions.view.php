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
    foreach ($array as $numero => $row) :
        $numero++;
        $datetime = $row['date_diffusion'];
        $dateAndHourArray = format_date($datetime);
        $date = $dateAndHourArray['date'];
        $heure = $dateAndHourArray['heure'];
        $id_film = $row['id_film'];
        $cycle = $row['cycle'];
        $affiche = $row['affiche'];
        $commentaire = $row['commentaire'];
        if (isset($films)) {
            $infos_film = $films->getAttributes($id_film);
            $titre = $infos_film['titre'];
            $realisateur = $infos_film['realisateur'];
        }
    
        include 'Templates/diffusion.php';
        
    endforeach; ?>

</section>