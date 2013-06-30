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
            <tr>
            <?php if ($droits == 2) : ?>
                <td class="numero"> <?php echo $numero; ?> </td>
            <?php endif; ?>
                <td class="titre"> <?php echo $titre; ?> </td>
                <td class="realisateur"> <?php echo $realisateur; ?> </td>
                <td class="annee"> <?php echo $annee; ?> </td>
                <td class="pays"> <?php echo $pays; ?> </td>
                <td class="acteurs"> <?php echo $acteurs; ?> </td>
                <td class="genre"> <?php echo $genre; ?> </td>
                <td class="synopsis">
                    <a onclick="afficheSynopsis(this);" data-syn="<?php echo htmlentities(utf8_decode($synopsis)); ?>">Voir</a>
                </td>
                <td class="affiche">
                    <a data-href="<?php echo $affiche; ?>" onclick="afficheAffiche(this);">Voir</a>
                </td>
                <td class="bande-annonce">
                    <a onclick="afficheBandeAnnonce(this);" data-ba="<?php echo $bande_annonce; ?>"> Voir </a>
                </td>
                <?php if ($droits == 2) : ?>
                <td class="support"> <?php echo $support; ?> </td>
                <td class="duree"> <?php echo $duree; ?> </td>
                <td class="modif-suppr">
                    <div class="inline hidden">
                    <form name="modifier_film" method="GET" action="films.php/modifier">
                        <input type="hidden" name="id" value="<?php echo $id;?>"/>
                        <input type="submit" value="Modifier"/>
                    </form>
                    </div>
                    <div class="inline hidden">
                        <form name="supprimer_film" method="GET" action="films.php/supprimer">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="button" value="Supprimer" id="confirme_suppr<?php echo $numero; ?>" onclick="confirme_suppression(<?php echo $numero; ?>);"/>
                            <input type="hidden" value="Oui" id="supprimer<?php echo $numero; ?>"/>
                            <input type="hidden" value="Non" id="annuler_suppr<?php echo $numero; ?>"/>
                        </form>
                    </div>
                </td>
                <?php elseif ($droits == 1) : ?>
                <td class="vote">
                    <input type="checkbox" form="form-vote" name="id<?php echo $numero; ?>" value="<?php echo $id; ?>" />
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </section>

    <?php if ($droits == 2) : ?>
    <div class="options">
        <a class="button" href="films.php/ajouter">Ajouter un film</a>
    </div>
<?php elseif ($droits == 1) : ?>
<form name="voter" id="form-vote" method="POST" action="films.php/voter">
    <input name="voter" type="submit" id="soumettre_vote" form="form-vote" value="Voter"/>
</form>
<?php endif; ?>