<?php
require_once 'Lib/dates.php';
?>

<h2>Bienvenue sur le site du 
    <span class="texte-cinetoile">Cin&eacute;&CloseCurlyQuote;toile</span>
    <?php if (isset($prenom)) : ?>
        <?php echo ", "; ?>
    <span class="texte-prenom"><?php echo "$prenom"; ?></span>
    <?php endif; ?>
    !
</h2>

<!--La section correspond à plusieurs films à venir-->
<section id="main">
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
            $synopsis = $infos_film['synopsis'];
            $bande_annonce = $infos_film['bande_annonce'];
        }
        
        include 'Templates/seance.php';
    
    endforeach; ?>
    
</section>