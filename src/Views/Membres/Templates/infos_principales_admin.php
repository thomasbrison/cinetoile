<fieldset>
    <legend>Informations principales sur le membre</legend>
    <p>
        <label>Login :  </label>
        <input type="text" name="login" size="25" maxlength="32" oninput="checkLogin(this.value);" value="<?php if (isset($login)) echo $login; ?>" placeholder="Login - sans accents" pattern="([A-za-z0-9]+|Cinétoile)" required autofocus />
        <span id="loginExists"></span>
    </p>
    <?php if (isset($login)) : ?>
        <p>
            <label>Nouveau mot de passe : </label>
            <input type="password" name="password1" size="25" maxlength="64" placeholder="Mot de passe" />
        </p>
        <p>
            <label>Nouveau mot de passe (confirmation) : </label>
            <input type="password" name="password2" size="25" maxlength="64" placeholder="Mot de passe" />
        </p>
    <?php endif; ?>
    <?php if (isset($droits)) : ?>
        <p>
            <label>Droits : </label>
            <?php include 'selection_droits.php'; ?>
        </p>
    <?php else : ?>
        <input type="hidden" name="droits" value="<?php echo Rights::BASIC; ?>"/>
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
