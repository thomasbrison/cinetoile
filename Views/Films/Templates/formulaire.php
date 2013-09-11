<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="films.php/<?php echo $form_action; ?>" enctype="multipart/form-data">

    <fieldset>
        <legend>Informations obligatoires sur le film</legend>
        <input type="hidden" name="id" <?php if (isset($id)) echo "value=$id"; ?>/>
        <p>
            <label>Titre :  </label>
            <input type="text" name="titre" size="25" maxlength="64" value="<?php if (isset($titre)) echo $titre; ?>" placeholder="Titre du film" required autofocus/>
        </p> 
        <p>
            <label>R&eacute;alisateur : </label>
            <input type="text" name="realisateur" size="25" maxlength="64" value="<?php if (isset($realisateur)) echo $realisateur; ?>" placeholder="Réalisateur(s) du film" required/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informations compl&eacute;mentaires sur le film</legend>
        <p>
            <label>Ann&eacute;e :  </label>
            <select name="annee">
                <option value=NULL <?php if (!isset($annee)) echo "selected"; ?>>Ann&eacute;e</option>
                <?php for ($i = 1930; $i <= 2010; $i++) : ?>
                <option value=<?php echo $i; ?> <?php if (isset($annee) && $i === $annee) echo "selected"; ?>>
                    <?php echo $i; ?>
                </option>
                <?php endfor; ?>
            </select>
        </p>
        <p>
            <label>Pays : </label>
            <input type="text" name="pays" size="16" maxlength="32" value="<?php if (isset($pays)) echo $pays; ?>" placeholder="Origine"/>
        </p>
        <p>
            <label>Acteurs : </label>
            <input type="text" name="acteurs" size="37" maxlength="128" value="<?php if (isset($acteurs)) echo $acteurs; ?>" placeholder="Acteurs principaux"/>
        </p>
        <p>
            <label>Genre : </label>
            <input type="text" name="genre" size="25" maxlength="64" value="<?php if (isset($genre)) echo $genre; ?>" placeholder="Genre du film"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informations sur le support</legend>
        <p>
            <label>Support : </label>
            <select name="support">
                <option value=NULL <?php if (!isset($support)) echo "selected"; ?>>Choisir le support</option>
                <option value="DVD" <?php if (isset($support) && $support === "DVD") echo "selected"; ?>>DVD</option>
                <option value="VHS" <?php if (isset($support) && $support === "VHS") echo "selected"; ?>>VHS</option>
            </select>
        </p>
        <p>
            <label>Dur&eacute;e : </label>
            <span>
                <select name="heures_duree">
                    <option value=-1 <?php if (isset($array_duration) && !$array_duration['hours']) echo "selected"; ?>>Heures</option>
                    <?php for ($i = 0; $i <= 3; $i++) : ?>
                    <option value=<?php echo $i; ?> <?php if (isset($array_duration) && $i === $array_duration['hours']) echo "selected"; ?>>
                        <?php echo $i; ?>
                    </option>
                        <?php endfor; ?>
                </select>
                :
                <select name="minutes_duree">
                    <option value=-1 <?php if (isset($array_duration) && !$array_duration['minutes']) echo "selected"; ?>>Minutes</option>
                    <?php for ($i = 0; $i <= 59; $i++) : ?>
                    <option value=<?php echo $i; ?> <?php if (isset($array_duration) && $i === $array_duration['minutes']) echo "selected"; ?>>
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </span>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informations annexes</legend>
        <p>
            <label>Synopsis : </label><br/>
            <textarea name="synopsis" rows="5" cols="40" maxlength="2048" placeholder='Veuillez entrer le synopsis du film.'><?php if (isset($synopsis)) echo $synopsis; ?></textarea>
        </p>
        <p class="film">
            <label>Affiche : </label><br/>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
            <?php if (isset($affiche) && $affiche) : ?>
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
        <p>
            <label>Bande-annonce : </label>
            <input type="text" name="bande_annonce" value="<?php if (isset($bande_annonce)) echo $bande_annonce; ?>" placeholder="Lien à insérer"/>
        </p>
            <?php if (isset($bande_annonce) && $bande_annonce) : ?>
        <p>
            <a class="button big-button" onclick="afficheBandeAnnonce(this);" data-ba="<?php echo $bande_annonce; ?>"> Voir la bande-annonce Allociné </a>
        </p>
            <?php endif; ?>
    </fieldset>
    
    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button type='button' onclick='window.location.href = "films.php";'>Annuler</button>
    </p>

</form>
