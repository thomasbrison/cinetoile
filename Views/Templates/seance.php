<?php
require_once 'Lib/dates.php';
require_once 'Lib/durees.php';

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

<article class="seance" id="seance<?php echo $page; ?>">
    <div id="fb-root"></div>

    <h2>
        <?php echo "$date à $heure" . ' : ' . $titre; ?>
    </h2>

    <?php if ($cycle) : ?>
    <h3>
        Cycle <?php echo $cycle; ?>
    </h3>
    <?php endif; ?>

    <?php if ($affiche) : ?>
    <div class="semi colonne">
        <img class="affiche" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt="Affiche introuvable."/>
    </div>
    <div class="semi colonne description">
    <?php else : ?>
    <div class="description">
    <?php endif; ?>
        <?php if ($annee) : ?>
        <p>
            Date de sortie : <?php echo $annee; ?>
        </p>
        <?php endif; ?>
        <?php if ($duree) : ?>
        <p>
            Durée : <?php echo $duree; ?>
        </p>
        <?php endif; ?>
        <?php if ($realisateur) : ?>
        <p>
            Réalisé par <?php echo $realisateur; ?>
        </p>
        <?php endif; ?>
        <?php if ($acteurs) : ?>
        <p>
            Avec <?php echo $acteurs; ?>
        </p>
        <?php endif; ?>
        <?php if ($genre) : ?>
        <p>
            Genre : <?php echo $genre; ?>
        </p>
        <?php endif; ?>
        <?php if ($pays) : ?>
        <p>
            Nationalité : <?php echo $pays; ?>
        </p>
        <?php endif; ?>
        <?php if ($synopsis) : ?>
        <br/>
        <p>
            <?php echo $synopsis; ?>
        </p>
        <?php endif; ?>
        <?php if ($bande_annonce) : ?>
        <br/>
        <p>
            <button class="button big-button" onclick="afficheBandeAnnonce(this);" data-ba="<?php echo $bande_annonce; ?>"> Voir la bande-annonce Allociné </button>
        </p>
        <?php endif; ?>

    </div>

    <div class="social">
        <div class="fb-like" data-href="<?php echo $_SERVER["HTTP_HOST"] . root . "/?date=$datetime"; ?>" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
    </div>

    <?php if (isset($nb_pages)) : ?>
        <?php if ($page > 0) : ?>
            <button type="button" class="arrow arrow-left" onclick="loadPage(<?php echo $page . "," . ($page - 1) . "," . $nb_pages; ?>);">La semaine prochaine</button>
        <?php endif; ?>
        <?php if ($page < $nb_pages - 1) : ?>
            <button type="button" class="arrow arrow-right" onclick="loadPage(<?php echo $page . "," . ($page + 1) . "," . $nb_pages; ?>);">La semaine dernière</button>
        <?php endif; ?>
    <?php endif; ?>

</article>