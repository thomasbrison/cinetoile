<?php
/*
 * Vue pour l'ajout d'une diffusion
 */

require_once 'Lib/dates.php';
?>

<form class="formulaire" name="ajout_diffusion" method="post" action="diffusions.php/ajouter" enctype="multipart/form-data">

    <fieldset>
        <legend></legend>
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
                    <?php for ($i = 1; $i <= 12; $i++) :
                        $mois = format_month($i);
                        ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $mois; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <select name="annee_diffusion">
                    <option value=NULL>Annee</option>
                    <?php for ($i = 2012; $i <= 2020; $i++) : ?>
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
                    <?php for ($i = 0; $i <= 59; $i = $i+5) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </span>
        </p>
        <p>
            <label>Film :  </label><br/>
            <select name="id_film">
                <?php foreach ($liste_films as $row) :
                    $id=$row['id'];
                    $titre=$row['titre'];
                    $realisateur=$row['realisateur'];
                    ?>
                <option value="<?php echo $id; ?>">
                    <?php echo "$titre  de  $realisateur"; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </p> 
        <p>
            <label>Cycle :  </label><br/>
            <input name="cycle" type="text" size="20" maxlength="48" placeholder="Nom du cycle"/>
        </p>
        <p>
            <label>Commentaire : </label><br/>
            <textarea name="commentaire" rows="5" cols="40" maxlength="256" onfocus="this.innerHTML='';">Commentaires ici...</textarea>
        </p>
        <p>
            <label>Affiche : </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
            <input type="file" name="affiche"/>
        </p>
    </fieldset>
    
    <p id="boutons">
        <input type="submit" name="ajouter" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button formaction="diffusions.php">Annuler</button>
    </p>

</form>
