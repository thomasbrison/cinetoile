<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="<?php echo $form_target; ?>" <?php if ('ajouter' === $form_action) echo 'onsubmit="return !loginExists;"'; ?>>

    <?php include $_SESSION['droits'] === Rights::ADMIN ? 'infos_principales_admin.php' : 'infos_principales_membre.php'; ?>

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
            <input type="tel" name="tel2" size="1" maxlength="2" value="<?php if (isset($tel2)) echo $tel2; ?>" placeholder="00" />
            .
            <input type="tel" name="tel3" size="1" maxlength="2" value="<?php if (isset($tel3)) echo $tel3; ?>" placeholder="00" />
            .
            <input type="tel" name="tel4" size="1" maxlength="2" value="<?php if (isset($tel4)) echo $tel4; ?>" placeholder="00" />
            .
            <input type="tel" name="tel5" size="1" maxlength="2" value="<?php if (isset($tel5)) echo $tel5; ?>" placeholder="00" />
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>&Eacute;tudes</legend>
        <p>
            <label>&Eacute;cole : </label>
            <?php include 'selection_ecole.php'; ?>
        </p>
        <p>
            <label>Ann&eacute;e : </label>
            <?php include 'selection_annee.php'; ?>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset" />
        <button type='button' onclick='window.location.href = "<?php echo $form_base; ?>";'>Annuler</button>
    </p>

</form>
