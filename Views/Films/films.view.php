<?php
/*
 * Vue des films
 */
function taille($droits, $width_admin, $width_membre) {
    if ($droits == 2) {
        echo $width_admin;
    } else if ($droits == 1) {
        echo $width_membre;
    }
}
?>

<div id="lightbox"></div>
    
    <section id="tableFilms">
        <table class="films <?php 
            if ($droits == 1) {
                echo "membre table_membre";
            } elseif ($droits == 2) {
                echo "admin";
            }?>">
        <caption>Liste des films</caption>

        <thead>
            <tr>
                <?php if ($droits == 2) : ?>
                <th class="numero"> &nbsp; </th>
                <?php endif; ?>
                <th class="titre"> Titre </th>
                <th class="realisateur"> R&eacute;alisateur </th>
                <th class="annee"> Ann&eacute;e </th>
                <th class="pays"> Pays </th>
                <th class="acteurs"> Acteurs </th>
                <th class="genre"> Genre </th>
                <th class="synopsis"> Synopsis </th>
                <th class="affiche"> Affiche du film </th>
                <th class="bande-annonce"> Bande-annonce </th>
                <?php if ($droits == 2) : ?>
                <th class="support"> Support </th>
                <th class="duree"> Dur&eacute;e </th>
                <th class="modif-suppr"> &nbsp; </th>
                <?php elseif ($droits == 1) : ?>
                <th class="vote"> Vote </th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($films as $numero => $film) :
            $numero = $numero + 1;
            $id = $film->getId();
            $titre = $film->getTitre();
            $realisateur = $film->getRealisateur();
            $annee = $film->getAnnee();
            $pays = $film->getPays();
            $acteurs = $film->getActeurs();
            $genre = $film->getGenre();
            $support = $film->getSupport();
            $duree = substr($film->getDuree(), 0, 5);
            $synopsis = $film->getSynopsis();
            $affiche = $film->getAffiche();
            $bande_annonce = $film->getBandeAnnonce();
            ?>
            <tr id="<?php echo $numero; ?>">
            <?php if ($droits == 2) : ?>
                <td class="numero" id="num<?php echo $numero ?>"> <?php echo $numero; ?> </td>
            <?php endif; ?>
                <td class="titre" id="titre<?php echo $numero ?>"> <?php echo $titre; ?> </td>
                <td class="realisateur" id="realisateur<?php echo $numero ?>"> <?php echo $realisateur; ?> </td>
                <td class="annee" id="annee<?php echo $numero ?>"> <?php echo $annee; ?> </td>
                <td class="pays" id="pays<?php echo $numero ?>"> <?php echo $pays; ?> </td>
                <td class="acteurs" id="acteurs<?php echo $numero ?>"> <?php echo $acteurs; ?> </td>
                <td class="genre" id="genre<?php echo $numero ?>"> <?php echo $genre; ?> </td>
                <td class="synopsis" id="synopsis<?php echo $numero ?>">
                    <a href="films.php#" onclick="afficheSynopsis(<?php echo $numero ?>);">Voir</a>
                    <p><?php echo $synopsis; ?></p>
                </td>
                <td class="affiche" id="affiche<?php echo $numero ?>">
                    <a href="films.php#" data-href="<?php echo $affiche; ?>" onclick="afficheAffiche(<?php echo $numero ?>);">Voir</a>
                </td>
                <td class="bande-annonce" id="bande_annonce<?php echo $numero ?>">
                    <a href="films.php#" onclick="afficheBandeAnnonce(<?php echo $numero ?>);"> Voir </a>
                    <div><?php echo $bande_annonce; ?></div>
                </td>
                <?php if ($droits == 2) : ?>
                <td class="support" id="support<?php echo $numero ?>"> <?php echo $support; ?> </td>
                <td class="duree" id="duree<?php echo $numero ?>"> <?php echo $duree; ?> </td>
                <td class="modif-suppr">
                    <div class="inline hidden" id="modif<?php echo $numero ?>">
                    <form name="modifier_film" method="GET" action="films.php/modifier">
                        <input type="hidden" name="id" value="<?php echo $id;?>"/>
                        <input type="submit" name="modifier_film" value="Modifier"/>
                    </form>
                    </div>
                    <div class="inline hidden" id="suppr<?php echo $numero ?>">
                        <form name="supprimer_film" method="GET" action="films.php/supprimer">
                            <input type="hidden" name="id" value="<?php echo $numero; ?>"/>
                            <input type="button" name="confirmer_suppression" value="Supprimer" id="confirme_suppr<?php echo $numero; ?>" onclick="confirme_suppression(<?php echo $numero; ?>);"/>
                            <input type="hidden" name="supprimer" value="Oui" id="supprimer<?php echo $numero; ?>"  onclick="document.getElementById('input-modif').setAttribute('value', <?php echo $id;?>);"/>
                            <input type="hidden" name="annuler" value="Non" id="annuler_suppr<?php echo $numero; ?>"/>
                        </form>
                    </div>
                </td>
                <?php elseif ($droits == 1) : ?>
                <td class="vote" onclick="voter('vote<?php echo $numero ?>');">
                    <input type="radio" name="id" value="<?php echo $id; ?>" id="vote<?php echo $numero ?>"/>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </section>

    <?php if ($droits == 2) : ?>
    <div class="options">
        <div id="ajout_film">
            <a href="films.php/ajouter">Ajouter un film</a>
        </div>
    </div>
<?php elseif ($droits == 1) : ?>
<form id="form-vote" name="voter" method="POST" action="films.php/voter">
    <input type="hidden" id="soumettre_vote" form="form-vote" value="Voter"/>
</form>
<?php endif; ?>