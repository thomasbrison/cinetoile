<?php
$membre = $table_membre->getAttributes($vote->getLogin());
$film = $table_film->getAttributes($vote->getIdFilm());
?>

<div>
    <p><?php echo $membre->getPrenom() . ' ' . $membre->getNom(); ?></p>
    <p><?php echo $vote->getDate(); ?></p>
    <p><?php echo $film->getTitre() . ' de ' . $film->getRealisateur(); ?></p>
</div>