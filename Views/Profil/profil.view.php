<?php
require_once 'Lib/annee.php';
require_once 'Lib/telephone.php';
?>

<?php if ($is_password_changed) : ?>
<p class="message">Mot de passe modifié avec succès !</p>
<?php endif; ?>

<dl>
    <dt>Login : </dt>
    <dd><?php echo $membre->getLogin(); ?></dd>

    <dt>Pr&eacute;nom : </dt>
    <dd><?php echo $membre->getPrenom(); ?></dd>

    <dt>Nom : </dt>
    <dd><?php echo $membre->getNom(); ?></dd>

    <dt>E-mail : </dt>
    <dd><?php echo $membre->getEmail(); ?></dd>

    <dt>T&eacute;l&eacute;phone : </dt>
    <dd><?php echo telephone_format($membre->getTelephone()); ?></dd>

    <dt>&Eacute;cole : </dt>
    <dd><?php echo $membre->getEcole(); ?></dd>

    <dt>Ann&eacute;e : </dt>
    <dd><?php echo annee_format($membre->getAnnee()); ?></dd>
</dl>

<div class="options">
    <a class="button" href="profil.php/modifier">Modifier le profil</a>
    <a class="button" href="profil.php/supprimer">Supprimer le profil</a>
</div>

