<?php
require_once 'Lib/dates.php';
$current_school_year = date_get_current_school_year();
?>

<footer>
    <img id="logo-cinetoile" class="logo" src="Images/Logos/cinetoile.png">
    <img id="logo-gc" class="logo" src="Images/Logos/gc.png">
    <div id="contenu-footer">
        <p>
            En construction
        </p>
        <address>
            <a href="mailto:cinetoile.grenoble@gmail.com">Envoyer un mail</a>.
        </address>
        <p>
            Cinétoile <?php echo $current_school_year['first_year'] . " - " . $current_school_year['second_year']; ?>
        </p>
    </div>
</footer>
