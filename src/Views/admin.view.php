<?php
/*
 * Vue pour l'administration
 */
?>

<h2>Quel beau plaisir de te revoir, <span class="texte-prenom"><?php echo $prenom; ?></span> !</h2>

<ul class="liste-admin">
    <li>
        <a class='button' href="<?php echo Routes::members;?>">Les membres</a>
    </li>
    <li>
        <a class='button' href="<?php echo Routes::films;?>">Les films</a>
    </li>
    <li>
        <a class='button' href="<?php echo Routes::diffusions;?>">Les séances</a>
    </li>
    <li>
        <a class='button' href="<?php echo Routes::profile;?>">Mon profil</a>
    </li>
    <li>
        <a class='button' href="<?php echo Routes::map;?>">Le plan d'accès</a>
    </li>
    <li>
        <a class='button' href="<?php echo Routes::presentation;?>">L'association</a>
    </li>
</ul>
