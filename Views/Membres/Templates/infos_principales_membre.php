<fieldset>
    <legend>Informations principales</legend>
    <p>
        <label>Mot de passe actuel : </label>
        <input type="password" name="current_password" size="25" maxlength="64" placeholder="Mot de passe" />
    </p>
    <p>
        <label>Nouveau mot de passe : </label>
        <input type="password" name="password1" size="25" maxlength="64" placeholder="Mot de passe" />
    </p>
    <p>
        <label>Nouveau mot de passe (confirmation) : </label>
        <input type="password" name="password2" size="25" maxlength="64" placeholder="Mot de passe" />
    </p>
    <p>
        <label>Pr&eacute;nom : </label>
        <input type="text" name="prenom" size="25" maxlength="32" value="<?php if (isset($prenom)) echo $prenom; ?>" placeholder="Prénom" required />
    </p>
    <p>
        <label>Nom : </label>
        <input type="text" name="nom" size="25" maxlength="32" value="<?php if (isset($nom)) echo $nom; ?>" placeholder="Nom"/>
    </p>
</fieldset>
