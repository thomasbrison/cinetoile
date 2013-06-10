<?php
/*
 * Vue pour l'ajout d'un film
 */
?>

<form class="formulaire" name="ajout_film" method="post" action="films.php/ajouter" enctype="multipart/form-data">

    <fieldset>
        <legend>Informations obligatoires sur le film</legend>
        <p>
            <label>Titre :  </label>
            <input type="text" name="titre" size="25" maxlength="64" placeholder="Titre du film" required autofocus/>
        </p> 
        <p>
            <label>R&eacute;alisateur : </label>
            <input type="text" name="realisateur" size="25" maxlength="64" placeholder="Réalisateur(s) du film" required/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informations compl&eacute;mentaires sur le film</legend>
        <p>
            <label>Ann&eacute;e :  </label>
            <select name="annee">
                <option value=NULL selected>Année</option>
                <?php for ($i = 1930; $i <= 2010; $i++) : ?>
                <option value="<?php echo $i; ?>">
                    <?php echo $i; ?>
                </option>
                <?php endfor; ?>
            </select>
        </p>
        <p>
            <label>Pays : </label>
            <input type="text" name="pays" size="16" maxlength="32" placeholder="Origine"/>
        </p>
        <p>
            <label>Acteurs : </label>
            <input type="text" name="acteurs" size="40" maxlength="128" placeholder="Acteurs principaux"/>
        </p>
        <p>
            <label>Genre : </label>
            <input type="text" name="genre" size="25" maxlength="64" placeholder="Genre du film"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Informations sur le support</legend>
        <p>
            <label>Support : </label>
            <select name="support">
                <option value=NULL selected>Choisir le support</option>
                <option value="DVD">DVD</option>
                <option value="VHS">VHS</option>
            </select>
        </p>
        <p>
            <label>Dur&eacute;e : </label>
            <span>
                <select name="heures_duree">
                    <option value=NULL selected>Heures</option>
                    <?php for ($i = 0; $i <= 3; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                :
                <select name="minutes_duree">
                    <option value=NULL selected>Minutes</option>
                    <?php for ($i = 0; $i <= 59; $i++) : ?>
                    <option value="<?php echo $i; ?>">
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
            <textarea name="synopsis" rows="5" cols="40" maxlength="2048" onfocus="this.innerHTML='';">Veuillez entrer le synopsis du film.</textarea>
        </p>
        <p>
            <label>Affiche : </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
            <input type="file" name="affiche"/>
        </p>
        <p>
            <label>Bande-annonce : </label>
            <input type="text" name="bande_annonce" placeholder="Balise à insérer"/>
        </p>
    </fieldset>
    
    <p id="boutons">
        <input type="submit" name="ajouter" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button formaction="films.php">Annuler</button>
    </p>

</form>
