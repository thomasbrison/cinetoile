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
    $liste_diffusions = array_reverse($liste_diffusions); 
    foreach ($liste_diffusions as $numero => $row) :
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
            $synopsis = $infos_film['synopsis'];
            $bande_annonce = $infos_film['bande_annonce'];
        }
        
        include 'Templates/seance.php';
    
    endforeach; ?>
    
</section>