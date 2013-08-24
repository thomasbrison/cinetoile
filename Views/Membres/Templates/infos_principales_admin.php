<fieldset>
    <legend>Informations principales sur le membre</legend>
    <p>
        <label>Login :  </label>
        <input type="text" name="login" size="25" maxlength="32" value="<?php if (isset($login)) echo $login; ?>" placeholder="Login - sans accents" pattern="([A-za-z]+|Cinétoile)" required autofocus />
    </p>
    <?php if (!isset($login) || (isset($droits) && $droits >= 2)) : ?>
        <p>
            <label>Mot de passe : </label>
            <input type="password" name="password" size="25" maxlength="64" placeholder="Mot de passe" <?php if (!isset($login)) echo "required"; ?> />
        </p>
    <?php endif; ?>
    <?php if (isset($droits)) : ?>
        <p>
            <label>Droits : </label>
            <select name="droits">
                <option value="1" <?php if (isset($droits) && $droits === "1") echo "selected"; ?>>Membre</option>
                <option value="2" <?php if (isset($droits) && $droits === "2") echo "selected"; ?>>Administrateur</option>
            </select>
        </p>
    <?php else : ?>
        <input type="hidden" name="droits" value="1"/>
    <?php endif; ?>
    <p>
        <label>Pr&eacute;nom : </label>
        <input type="text" name="prenom" size="25" maxlength="32" value="<?php if (isset($prenom)) echo $prenom; ?>" placeholder="Prénom" required />
    </p>
    <p>
        <label>Nom : </label>
        <input type="text" name="nom" size="25" maxlength="32" value="<?php if (isset($nom)) echo $nom; ?>" placeholder="Nom" />
    </p>
</fieldset>
