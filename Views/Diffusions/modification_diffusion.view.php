<?php
/*
 * Vue pour la modification d'une diffusion
 */
?>

<form class="formulaire" name="modification_diffusion" method="post" action="diffusions.php/modifier" enctype="multipart/form-data">

    <fieldset>
        <legend></legend>
        <input type="hidden" name="date" value="<?php echo $date; ?>"/>
        <p>
            <label>Film :  </label>
            <select name="id_film">
            <?php foreach ($liste_films as $row) :
                $id = $row['id'];
                $titre = $row['titre'];
                $realisateur = $row['realisateur'];
                ?>
                <option value="<?php echo $id; ?>" <?php if ($id == $id_film) echo "selected"; ?>>
                    <?php echo "$titre  de  $realisateur"; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label>Cycle :  </label><br/>
            <input name="cycle" type="text" size="20" maxlength="48" value="<?php echo $cycle; ?>" placeholder="Nom du cycle"/>
        </p>
        <p>
            <label>Commentaire : </label><br/>
            <textarea name="commentaire" rows="5" cols="40" maxlength="256">
                <?php echo $commentaire; ?>
            </textarea>
        </p>
        <p class="film">
            <label>Affiche : </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
            <?php if ($affiche) : ?>
            <br/>
            <img class="affiche" name="affiche" src="<?php echo $affiche; ?>" alt=""/>
            <br/>
            <span id="buttons">
                <input type="hidden" name="etat_affiche" value="0"/>
                <button onclick="modifier_affiche(); return false;">Modifier l'affiche</button>
                <button onclick="supprimer_affiche(); return false;">Supprimer l'affiche</button>
            </span>
            <?php else : ?>
            <input type="file" name="affiche"/>
            <?php endif; ?>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="modifier" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button formaction="diffusions.php">Annuler</button>
    </p>

</form>
