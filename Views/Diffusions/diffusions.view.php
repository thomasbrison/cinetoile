<?php
/*
 * Vue des diffusions
 */

require_once 'Models/tools.php';
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
        $date_diff = date("d m Y H i", strtotime($datetime));
        $numero_mois = substr($datetime, 3, 2);
        $mois = format_month($numero_mois);
        $date_format = substr_replace($date_diff, 'H', 13, 1);
        $date_sans_mois = substr($date_format, 0, 10);
        $heure = substr($date_format, 11, 5);
        $date = substr_replace($date_sans_mois, $mois, 3, 2);
        $id_film = $row['id_film'];
        $cycle = $row['cycle'];
        $affiche = $row['affiche'];
        $commentaire = $row['commentaire'];
        if (isset($films)) {
            $infos_film = $films->getAttributes($id_film);
            $titre = $infos_film['titre'];
            $realisateur = $infos_film['realisateur'];
        }
        ?>
    <article class="film">
        <h2>Le <?php echo "$date à $heure"; ?> :</h2>
        <p><?php echo "$titre  de  $realisateur"; ?></p>
        <p>
            <?php if ($cycle) : ?>
            Cycle <em><i><?php echo $cycle?></i></em>
            <?php endif; ?>
        </p>
        <?php if ($affiche) : ?>
        <img class="affiche" name="affiche" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt=""/>
        <?php endif; ?>
        <p><?php echo $commentaire; ?></p>
        <div class="inline buttons">
            <div class="inline hidden">
                <form name="modifier_diffusion" method="GET" action="diffusions.php/modifier">
                    <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
                    <input type="submit" name="modifier_diffusion" value="Modifier"/>
                </form>
            </div>
            <div class="inline hidden">
                <form name="supprimer_diffusion" method="GET" action="diffusions.php/supprimer">
                    <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
                    <input type="button" name="confirmer_suppression" value="Supprimer" id="confirme_suppr<?php echo $numero; ?>" onclick="confirme_suppression(<?php echo $numero; ?>);"/>
                    <input type="hidden" name="supprimer" value="Oui" id="supprimer<?php echo $numero; ?>"/>
                    <input type="hidden" name="annuler" value="Non" id="annuler_suppr<?php echo $numero; ?>"/>
                </form>
            </div>
        </div>
    </article>
    <?php
    $mod_id = $numero % 10;
    if ($mod_id == 9) {
        echo "</section>\n";
        $nb_id = ($numero + 1) / 10;
        echo "<section id='$nb_id'>\n";
    }
    endforeach; ?>

</section>