<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="<?php echo "$form_target/$form_action"; ?>">

    <?php include $_SESSION['droits'] === Rights::$ADMIN ? 'infos_principales_admin.php' : 'infos_principales_membre.php'; ?>

    <br/>
    <fieldset>
        <legend>Coordon&eacute;es</legend>
        <p>
            <label>e-mail : </label>
            <input type="email" name="email" size="25" maxlength="64" value="<?php if (isset($email)) echo $email; ?>" placeholder="E-mail" />
        </p>
        <p>
            <label>T&eacute;l&eacute;phone : </label>
            <input type="tel" name="tel1" size="1" maxlength="2" value="<?php if (isset($tel1)) echo $tel1; ?>" placeholder="06" />
            .
            <input type="tel" name="tel2" size="1" maxlength="2" value="<?php if (isset($tel2))echo $tel2; ?>" placeholder="00" />
            .
            <input type="tel" name="tel3" size="1" maxlength="2" value="<?php if (isset($tel3))echo $tel3; ?>" placeholder="00" />
            .
            <input type="tel" name="tel4" size="1" maxlength="2" value="<?php if (isset($tel4))echo $tel4; ?>" placeholder="00" />
            .
            <input type="tel" name="tel5" size="1" maxlength="2" value="<?php if (isset($tel5))echo $tel5; ?>" placeholder="00" />
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>&Eacute;tudes</legend>
        <p>
            <label>&Eacute;cole : </label>
            <select name="ecole">
                <option value=NULL <?php if (!isset($ecole)) echo "selected"; ?>>Choisir l'&eacute;cole</option>
                <option value="Ense3" <?php if (isset($ecole) && $ecole === "Ense3") echo "selected"; ?>>Ense3</option>
                <option value="Ensimag" <?php if (isset($ecole) && $ecole === "Ensimag") echo "selected"; ?>>Ensimag</option>
                <option value="GI" <?php if (isset($ecole) && $ecole === "GI") echo "selected"; ?>>Génie Industriel</option>
                <option value="Pagora" <?php if (isset($ecole) && $ecole === "Pagora") echo "selected"; ?>>Pagora</option>
                <option value="Phelma" <?php if (isset($ecole) && $ecole === "Phelma") echo "selected"; ?>>Phelma</option>
                <option value="Autre" <?php if (isset($ecole) && $ecole === "Autre") echo "selected"; ?>>Autre</option>
            </select>
        </p>
        <p>
            <label>Ann&eacute;e : </label>
            <select name="annee">
                <option value=NULL <?php if (!isset($annee)) echo "selected"; ?>>
                    Choisir l'ann&eacute;e d'&eacute;tude
                </option>
                <option value="1" <?php if (isset($annee) && $annee === "1") echo "selected"; ?>>1A</option>
                <option value="2" <?php if (isset($annee) && $annee === "2") echo "selected"; ?>>2A</option>
                <option value="3" <?php if (isset($annee) && $annee === "3") echo "selected"; ?>>3A</option>
                <option value="Autre" <?php if (isset($annee) && $annee === "Autre") echo "selected"; ?>>Autre</option>
            </select>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset" />
        <button type='button' onclick='window.location.href = "<?php echo $form_target; ?>";'>Annuler</button>
    </p>

</form>
