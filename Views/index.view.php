<h2>Bienvenue sur le site du 
    <span class="texte-cinetoile">Cin&eacute;&CloseCurlyQuote;toile</span>
    <?php if (isset($prenom)) : ?>
        <?php echo ", "; ?>
        <span class="texte-prenom"><?php echo "$prenom"; ?></span>
    <?php endif; ?>
    !
</h2>

<section id="main" class="three-pages">
    <div id="lightbox"></div>
    
    <?php include 'Templates/seance.php'; ?>

</section>