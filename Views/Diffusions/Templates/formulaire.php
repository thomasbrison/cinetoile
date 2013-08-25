<?php
require_once 'Lib/dates.php';

if (isset($diffusion)) {
    $datetime = $diffusion->getDate();
    $date_and_hour_array = date_format_to_string($datetime);
    $date = $date_and_hour_array['date'];
    $heure = $date_and_hour_array['heure'];
    $id_film = $diffusion->getIdFilm();
    $cycle = $diffusion->getCycle();
    $affiche = $diffusion->getAffiche();
    $commentaire = $diffusion->getCommentaire();
    $nb_presents = $diffusion->getNbPresents();
}
?>

<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="diffusions.php/<?php echo $form_action; ?>" enctype="multipart/form-data">

    <fieldset>
        <legend></legend>
        <?php if (isset($datetime)) : ?>
        <input type="hidden" name="date" value="<?php echo $datetime; ?>"/>
        <?php else : ?>
        <p>
            <label>Date : </label>
            <span>
                <select name="jour_diffusion">
                    <option value=NULL>Jour</option>
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <select name="mois_diffusion">
                    <option value=NULL>Mois</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++) :
                        $mois = date_format_month_to_string($i);
                        ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $mois; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <select name="annee_diffusion">
                    <option value=NULL>Annee</option>
                    <?php for ($i = 2013; $i <= 2020; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                &nbsp;
                <select name="heure_diffusion">
                    <option value=NULL>Heure</option>
                    <?php for ($i = 0; $i <= 23; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                :
                <select name="minute_diffusion">
                    <option value=NULL>Minutes</option>
                    <?php for ($i = 0; $i <= 59; $i = $i + 5) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </span>
        </p>
        <?php endif; ?>
        <p>
            <label>Film :  </label>
            <select name="id_film">
                <?php
                foreach ($films as $film) :
                    $id = $film->getId();
                    $titre = $film->getTitre();
                    $realisateur = $film->getRealisateur();
                    ?>
                    <option value="<?php echo $id; ?>" <?php if (isset($id_film) && $id === $id_film) echo "selected"; ?>>
                        <?php echo "$titre  de  $realisateur"; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label>Cycle :  </label><br/>
            <input name="cycle" type="text" size="20" maxlength="48" value="<?php if (isset($cycle)) echo $cycle; ?>" placeholder="Nom du cycle"/>
        </p>
        <p>
            <label>Commentaire : </label><br/>
            <textarea name="commentaire" rows="5" cols="40" maxlength="256" placeholder='Insérez un commentaire.'><?php if (isset($commentaire)) echo $commentaire; ?></textarea>
        </p>
        <p class="film">
            <label>Affiche : </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
            <?php if (isset($affiche) && $affiche) : ?>
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
        <p>
            <label>Nombre de personnes présentes :  </label>
            <select name="nb_presents">
                    <option value="">
                    </option>
                <?php for ($i = 1; $i <= 100; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php if (isset($nb_presents) && (int) $nb_presents === $i) echo "selected"; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <input type='submit' name="annuler" value='Annuler'/>
    </p>

</form>
