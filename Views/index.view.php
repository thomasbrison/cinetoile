<?php
require_once 'Models/tools.php';
?>

<h2>Bienvenue sur le site du 
    <span class="texte-cinetoile">Cin&eacute;&CloseCurlyQuote;toile</span>
    <?php if (isset($prenom)) : ?>
        <?php echo ", "; ?>
    <span class="texte-prenom"><?php echo "$prenom"; ?></span>
    <?php endif; ?>
    !
</h2>

<!--La section correspond à plusieurs films à venir-->
<section id="main">
    <?php
    $liste_diffusions = array_reverse($liste_diffusions); 
    foreach ($liste_diffusions as $numero => $row) :
        $numero++;
        $datetime = $row['date_diffusion'];
        $date_diff = date("d m Y H i", strtotime($datetime));
        $numero_mois = substr($datetime, 3, 2);
        $mois = format_month($numero_mois);
        $date_format = substr_replace($date_diff, 'H', 13, 1);
        $date_sans_mois = substr($date_format, 0, 10);
        $heure = substr($date_format, 11, 5);
        $date = substr_replace($date_sans_mois, $mois, 3, 2);
        $id_film = $row['id_film'];
        $cycle = $row['cycle'];
        $affiche = $row['affiche'];
        $commentaire = $row['commentaire'];
        if (isset($films)) {
            $infos_film = $films->getAttributes($id_film);
            $titre = $infos_film['titre'];
            $realisateur = $infos_film['realisateur'];
            $synopsis = $infos_film['synopsis'];
            $bande_annonce = $infos_film['bande_annonce'];
        }
        ?>

    <!--Prochain film-->
    <article class="film" id="film<?php echo $numero; ?>">

        <div class="annonce">
            Le <?php echo "$jour"; ?> 
            <time class="date" datetime="<?php echo "$datetime"; ?>">
                <?php echo "$date"; ?>
            </time> 
            à 
            <span class="heure">
                <?php echo "$heure"; ?>
            </span>
            <br/>

            <?php if ($cycle) : ?>
            <?php echo "Pour le cycle "; ?>                	    
            <span class="cycle">
                <?php echo "$cycle"; ?>
            </span> 
            :
            <br/> 
            <?php endif; ?>
            <span class="titre">
                <?php echo "$titre"?>
            </span> 
            de 
            <span class="realisateur">
                <?php echo "$realisateur"; ?>
            </span>
        </div>

        <?php if ($commentaire) : ?>
        <div class="commentaire">
            <?php echo "$commentaire"; ?>
        </div>
        <?php endif; ?>

        <?php if ($affiche && $_SESSION['droits'] > 0) : ?>
        <div>
            <img class="affiche" name="affiche" src="<?php echo $affiche; ?>" title="<?php echo $titre; ?>" alt="Affiche introuvable."/>
        </div>
        <?php endif; ?>

        <?php if ($bande_annonce && $_SESSION['droits'] > 0) : ?>
        <div class="bande-annonce">
            <div class="dispVid" id="disp<?php echo $numero;?>" onclick="affichage_video('<?php echo $numero;?>');">Voir la bande-annonce</div>
            <div class="video" id="vid<?php echo $numero;?>">
                <?php echo $bande_annonce; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($synopsis) : ?>
            <!--<div class="annonce" style="font-weight: bold;">Synopsis</div>-->
        <div class="synopsis"><?php echo "$synopsis"; ?></div>
        <?php endif; ?>

        <!--<div class="social" id="social<?php /*echo $numero;*/?>">
            <div class="fb-like" data-href="http://www.google.fr" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>        
        </div>-->

    </article>
    <?php endforeach; ?>
</section>