<article class="seance">
    <h2>Le <?php echo "$date à $heure"; ?> :</h2>
    <h3><?php echo "$titre  de  $realisateur"; ?></h3>
    <?php if ($cycle) : ?>
    <p>
        Cycle <em><i><?php echo $cycle ?></i></em>
    </p>
    <?php endif; ?>
    <?php if ($affiche) : ?>
        <img class="affiche" name="affiche" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt=""/>
    <?php endif; ?>
    <p><?php echo $commentaire; ?></p>
    <?php if ($nb_presents) : ?>
    <p><?php echo $nb_presents; ?> personne(s) présente(s)</p>
    <?php endif; ?>
    <div class="buttons">
        <div class="inline-block invisible">
            <form name="modifier_diffusion" method="GET" action="<?php echo Routes::diffusionsUpdate;?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="submit" value="Modifier"/>
            </form>
        </div>
        <div class="inline-block invisible">
            <form name="supprimer_diffusion" method="GET" action="<?php echo Routes::diffusionsDelete;?>" onsubmit="return removeDiffusion(this);">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="button" value="Supprimer" onclick="confirm(this);"/>
            </form>
        </div>
    </div>
</article>