<article class="seance">
    <h2>Le <?php echo "$date à $heure"; ?> :</h2>
    <h3><?php echo "$titre  de  $realisateur"; ?></h3>
    <p>
        <?php if ($cycle) : ?>
            Cycle <em><i><?php echo $cycle ?></i></em>
        <?php endif; ?>
    </p>
    <?php if ($affiche) : ?>
        <img class="affiche" name="affiche" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt=""/>
    <?php endif; ?>
    <p><?php echo $commentaire; ?></p>
    <p><?php echo $nb_presents; ?> personne(s) présente(s)</p>
    <div class="buttons">
        <div class="inline-block invisible">
            <form name="modifier_diffusion" method="GET" action="diffusions.php/modifier">
                <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
                <input type="submit" value="Modifier"/>
            </form>
        </div>
        <div class="inline-block invisible">
            <form name="supprimer_diffusion" method="GET" action="diffusions.php/supprimer" onsubmit="return removeDiffusion(this);">
                <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
                <input type="button" value="Supprimer" onclick="confirm(this);"/>
            </form>
        </div>
    </div>
</article>