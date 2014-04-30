<?php
if (isset($membre)) {
    $login = $membre->getLogin();
    $prenom = $membre->getPrenom();
    $nom = $membre->getNom();
    $email = $membre->getEmail();
    $tel = $membre->getTelephone();
    $tel1 = substr($tel, 0, 2);
    $tel2 = substr($tel, 2, 2);
    $tel3 = substr($tel, 4, 2);
    $tel4 = substr($tel, 6, 2);
    $tel5 = substr($tel, 8, 2);
    $ecole = $membre->getEcole();
    $annee = $membre->getAnnee();
    $droits = $membre->getDroits();
}
?>

<form class="formulaire" name="<?php echo $form_name; ?>" method="post" action="<?php echo $form_target; ?>" <?php if ('ajouter' === $form_action) echo 'onsubmit="return !loginExists;"'; ?>>

    <?php include $infos_principales_view; ?>

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
            <?php include 'selection_ecole.view.php'; ?>
        </p>
        <p>
            <label>Ann&eacute;e : </label>
            <?php include 'selection_annee.view.php'; ?>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="<?php echo $form_action; ?>" value="Valider" />
        <input type="reset" name="reset" value="Reset" />
        <button type='button' onclick='window.location.href = "<?php echo $form_base; ?>";'>Annuler</button>
    </p>

</form>
