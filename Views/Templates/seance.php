<?php
require_once 'Lib/dates.php';
require_once 'Lib/durees.php';

$diffusion = $diffusions[$page];
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
    $genre = $infos_film['genre'];
    $annee = $infos_film['annee'];
    $pays = $infos_film['pays'];
    $acteurs = $infos_film['acteurs'];
    $synopsis = $infos_film['synopsis'];
    $duree = duree_format_duree($infos_film['duree']);
    $bande_annonce = $infos_film['bande_annonce'];
}
?>

<article class="film page" id="seance<?php echo $page; ?>">

        <!--<div class="social" id="social<?php /* echo $numero; */ ?>">
            <div class="fb-like" data-href="http://www.google.fr" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>        
        </div>-->

    <h2 style="color: white; text-shadow: black -1px 1px 1px;">
        <?php echo $date . ' : ' . $titre; ?>
    </h2>

    <div class="semi column">
        <img style="width: 100%;" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt="Affiche introuvable."/>
    </div>
    <div class="semi column">
        <p>
            Date de sortie : <?php echo $annee; ?>
        </p>
        <p>
            Durée : <?php echo $duree; ?>
        </p>
        <p>
            Réalisé par <?php echo $realisateur; ?>
        </p>
        <p>
            Avec <?php echo $acteurs; ?>
        </p>
        <p>
            Genre : <?php echo $genre; ?>
        </p>
        <p>
            Nationalité : <?php echo $pays; ?>
        </p>
        <br/>
        <p>
            <?php echo $synopsis; ?>
        </p>
    </div>

    <?php if ($page > 0) : ?>
        <button type="button" class="arrow-left" onclick="loadPage(<?php echo $page . "," . ($page - 1) . "," . $nb_pages; ?>);"></button>
    <?php endif; ?>
    <?php if ($page < $nb_pages - 1) : ?>
        <button type="button" class="arrow-right" onclick="loadPage(<?php echo $page . "," . ($page + 1) . "," . $nb_pages; ?>);"></button>
    <?php endif; ?>

</article>