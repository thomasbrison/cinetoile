<header>
    <nav id="nav-header" class="<?php echo $class_nav; ?>">
        <ul>
            <li>
                <a class="button" href="">Accueil</a>
            </li>
            <?php if ($_SESSION['droits'] >= Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="films.php">Films</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] === Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="profil.php">Mon profil</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] <= Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="plan.php">Plan</a>
                </li>
                <li>
                    <a class="button" href="presentation.php">L'association</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] === Rights::$ADMIN) : ?>
                <li>
                    <a class="button" href="membres.php">Membres</a>
                </li>
                <li>
                    <a class="button" href="diffusions.php">Séances</a>
                </li>
                <li>
                    <a class="button" href="admin.php">Administration</a>
                </li>
            <?php endif; ?>
            <li>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a class="button" href="index.php/deconnexion">D&eacute;connexion</a>
                <?php else : ?>
                    <a class="button" href="index.php/connexion">Connexion</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>

