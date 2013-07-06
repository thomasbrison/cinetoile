<?php
if (isset($diffusion)) {
    require_once 'Lib/dates.php';

    $datetime = $diffusion->getDate();
    $date_and_hour_array = date_format_to_string($datetime);
    $date = $date_and_hour_array['date'];
    $heure = $date_and_hour_array['heure'];
    $id_film = $diffusion->getIdFilm();
    $cycle = $diffusion->getCycle();
    $affiche = $diffusion->getAffiche();
    $commentaire = $diffusion->getCommentaire();
}
?>

<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="diffusions.php/<?php echo $form_action; ?>" enctype="multipart/form-data">

    <fieldset>
        <legend></legend>
        <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
        <p>
            <label>Film :  </label>
            <select name="id_film">
                <?php
                foreach ($films as $film) :
                    $id = $film->getId();
                    $titre = $film->getTitre();
                    $realisateur = $film->getRealisateur();
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
            <textarea name="commentaire" rows="5" cols="40" maxlength="256" placeholder='Insérez un commentaire.'><?php echo $commentaire; ?></textarea>
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
                    <button onclick="modifier_affiche();
                            return false;">Modifier l'affiche</button>
                    <button onclick="supprimer_affiche();
                            return false;">Supprimer l'affiche</button>
                </span>
            <?php else : ?>
                <input type="file" name="affiche"/>
            <?php endif; ?>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <input type='submit' name="annuler" value='Annuler'/>
    </p>

</form>
