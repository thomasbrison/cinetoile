<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="membres.php/<?php echo $form_action; ?>">

    <fieldset>
        <legend>Informations sur le membre</legend>
        <p>
            <label>Login :  </label>
            <input type="text" name="login" size="25" maxlength="32" value="<?php echo $login; ?>" placeholder="Login - sans accents" pattern="[A-za-z]+" required autofocus/>
        </p>
        <?php if (!$login) : ?>
        <p>
            <label>Mot de passe : </label>
            <input type="password" name="password" size="25" maxlength="64" placeholder="Mot de passe" required/>
        </p>
        <?php endif; ?>
        <?php if ($droits) : ?>
        <p>
            <label>Droits : </label>
            <select name="droits">
                <option value="1" <?php if ($droits == 1) echo "selected"; ?>>Membre</option>
                <option value="2" <?php if ($droits == 2) echo "selected"; ?>>Administrateur</option>
            </select>
        </p>
        <?php else : ?>
        <input type="hidden" name="droits" value="1"/>
        <?php endif; ?>
        <p>
            <label>Pr&eacute;nom : </label>
            <input type="text" name="prenom" size="25" maxlength="32" value="<?php echo $prenom; ?>" placeholder="Prénom" required/>
        </p>
        <p>
            <label>Nom : </label>
            <input type="text" name="nom" size="25" maxlength="32" value="<?php echo $nom; ?>" placeholder="Nom"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Coordon&eacute;es</legend>
        <p>
            <label>e-mail : </label>
            <input type="email" name="email" size="25" maxlength="64" value="<?php echo $email; ?>" placeholder="E-mail"/>
        </p>
        <p>
            <label>T&eacute;l&eacute;phone : </label>
            <input type="tel" name="tel1" size="1" maxlength="2" value="<?php echo $tel1; ?>" placeholder="06"/>
            .
            <input type="tel" name="tel2" size="1" maxlength="2" value="<?php echo $tel2; ?>" placeholder="00"/>
            .
            <input type="tel" name="tel3" size="1" maxlength="2" value="<?php echo $tel3; ?>" placeholder="00"/>
            .
            <input type="tel" name="tel4" size="1" maxlength="2" value="<?php echo $tel4; ?>" placeholder="00"/>
            .
            <input type="tel" name="tel5" size="1" maxlength="2" value="<?php echo $tel5; ?>" placeholder="00"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>&Eacute;tudes</legend>
        <p>
            <label>&Eacute;cole : </label>
            <select name="ecole">
                <option value=NULL <?php if (!$ecole) echo "selected"; ?>>Choisir l'&eacute;cole</option>
                <option value="Ense3" <?php if ($ecole == "Ense3") echo "selected"; ?>>Ense3</option>
                <option value="Ensimag" <?php if ($ecole == "Ensimag") echo "selected"; ?>>Ensimag</option>
                <option value="GI" <?php if ($ecole == "GI") echo "selected"; ?>>Génie Industriel</option>
                <option value="Pagora" <?php if ($ecole == "Pagora") echo "selected"; ?>>Pagora</option>
                <option value="Phelma" <?php if ($ecole == "Phelma") echo "selected"; ?>>Phelma</option>
                <option value="Autre" <?php if ($ecole == "Autre") echo "selected"; ?>>Autre</option>
            </select>
        </p>
        <p>
            <label>Ann&eacute;e : </label>
            <select name="annee">
                <option value=NULL <?php if (!$annee) echo "selected"; ?>>
                    Choisir l'ann&eacute;e d'&eacute;tude
                </option>
                <option value="1" <?php if ($annee == 1) echo "selected"; ?>>1A</option>
                <option value="2" <?php if ($annee == 2) echo "selected"; ?>>2A</option>
                <option value="3" <?php if ($annee == 3) echo "selected"; ?>>3A</option>
                <option value="Autre" <?php if ($annee == "Autre") echo "selected"; ?>>Autre</option>
            </select>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button formaction="membres.php">Annuler</button>
    </p>

</form>
