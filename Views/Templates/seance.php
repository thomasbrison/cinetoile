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
            <?php echo "$titre" ?>
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
            <img class="affiche" name="affiche" src="<?php echo $affiche; ?>"
                 title="<?php echo $titre; ?>" alt="Affiche introuvable."/>
        </div>
    <?php endif; ?>

    <?php if ($bande_annonce && $_SESSION['droits'] > 0) : ?>
        <div class="bande-annonce">
            <div class="dispVid" id="disp<?php echo $numero; ?>" onclick="affichage_video('<?php echo $numero; ?>');">
                Voir la bande-annonce
            </div>
            <div class="video" id="vid<?php echo $numero; ?>">
                <?php echo $bande_annonce; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($synopsis) : ?>
        <!--<div class="annonce" style="font-weight: bold;">Synopsis</div>-->
        <div class="synopsis"><?php echo "$synopsis"; ?></div>
    <?php endif; ?>

        <!--<div class="social" id="social<?php /* echo $numero; */ ?>">
            <div class="fb-like" data-href="http://www.google.fr" data-send="true" data-width="450" data-show-faces="true" data-action="recommend"></div>        
        </div>-->

</article>