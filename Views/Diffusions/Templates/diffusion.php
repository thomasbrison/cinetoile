<article class="film">
    <h2>Le <?php echo "$date à $heure"; ?> :</h2>
    <p><?php echo "$titre  de  $realisateur"; ?></p>
    <p>
        <?php if ($cycle) : ?>
            Cycle <em><i><?php echo $cycle ?></i></em>
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