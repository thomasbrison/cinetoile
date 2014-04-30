<header>
    <nav id="nav-header" class="<?php echo $class_nav; ?>">
        <ul>
            <li>
                <a class="button" href="">Accueil</a>
            </li>
            <?php if ($_SESSION['droits'] >= Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="<?php echo Routes::films; ?>">Films</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] === Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="<?php echo Routes::profile; ?>">Mon profil</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] <= Rights::$MEMBER) : ?>
                <li>
                    <a class="button" href="<?php echo Routes::plan; ?>">Plan</a>
                </li>
                <li>
                    <a class="button" href="<?php echo Routes::presentation; ?>">L'association</a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['droits'] === Rights::$ADMIN) : ?>
                <li>
                    <a class="button" href="<?php echo Routes::members; ?>">Membres</a>
                </li>
                <li>
                    <a class="button" href="<?php echo Routes::diffusions; ?>">Séances</a>
                </li>
                <li>
                    <a class="button" href="<?php echo Routes::admin; ?>">Administration</a>
                </li>
            <?php endif; ?>
            <li>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a class="button" href="<?php echo Routes::deconnection; ?>">D&eacute;connexion</a>
                <?php else : ?>
                    <a class="button" href="<?php echo Routes::connection; ?>">Connexion</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>

