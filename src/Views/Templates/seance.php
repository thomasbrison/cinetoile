<?php
require_once 'Lib/dates.php';
require_once 'Lib/durees.php';

$datetime = $diffusion->getDate();
$date_and_hour_array = date_format_to_string($datetime);
$date = $date_and_hour_array['date'];
$heure = $date_and_hour_array['time'];
$id_film = $diffusion->getIdFilm();
$cycle = $diffusion->getCycle();

$affiche = $diffusion->getAffiche();
$commentaire = $diffusion->getCommentaire();
if (isset($table_film)) {
    $film = $table_film->getAttributes($id_film);
    extract($film->arrayInfos());
    $duree = duree_format_duree($film->getDuree());
}
?>

<article class="seance" id="seance<?php if (isset($page)) {echo $page;} ?>">
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
            <strong>Date de sortie</strong> : <?php echo $annee; ?>
        </p>
        <?php endif; ?>
        <?php if ($duree) : ?>
        <p>
            <strong>Durée</strong> : <?php echo $duree; ?>
        </p>
        <?php endif; ?>
        <?php if ($realisateur) : ?>
        <p>
            <strong>Réalisé par</strong> <?php echo $realisateur; ?>
        </p>
        <?php endif; ?>
        <?php if ($acteurs) : ?>
        <p>
            <strong>Avec</strong> <?php echo $acteurs; ?>
        </p>
        <?php endif; ?>
        <?php if ($genre) : ?>
        <p>
            <strong>Genre</strong> : <?php echo $genre; ?>
        </p>
        <?php endif; ?>
        <?php if ($pays) : ?>
        <p>
            <strong>Nationalité</strong> : <?php echo $pays; ?>
        </p>
        <?php endif; ?>
        <?php if ($synopsis) : ?>
        <br/>
        <p>
            <?php echo $synopsis; ?>
        </p>
        <?php endif; ?>
        <?php if ($bandeAnnonce) : ?>
        <br/>
        <p>
            <button class="button big-button" onclick="afficheBandeAnnonce(this);" data-ba="<?php echo $bande_annonce; ?>"> Voir la bande-annonce Allociné </button>
        </p>
        <?php endif; ?>

    </div>

    <div class="social">
        <div class="fb-like" data-href="http://<?php echo $_SERVER["HTTP_HOST"] . Routes::getRoute(Routes::seeDiffusion, array($diffusion->getId())); ?>" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>
    </div>

    <?php if (isset($nb_pages)) : ?>
        <?php if ($page > 0) : ?>
            <button type="button" class="arrow arrow-left" onclick="loadPage(<?php echo $page . "," . ($page - 1) . "," . $nb_pages; ?>);">La semaine suivante</button>
        <?php endif; ?>
        <?php if ($page < $nb_pages - 1) : ?>
            <button type="button" class="arrow arrow-right" onclick="loadPage(<?php echo $page . "," . ($page + 1) . "," . $nb_pages; ?>);">La semaine précédente</button>
        <?php endif; ?>
    <?php endif; ?>

</article>