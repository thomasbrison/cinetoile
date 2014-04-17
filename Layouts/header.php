<?php
if (!isset($titre_page)) {
    $titre_page = "Ciné'toile - Grenoble INP";
} else {
    $titre_page = $titre_page . " - Ciné' toile";
}

switch ($_SESSION['droits']) {
    case Rights::$MEMBER:
        $class_links_header = "one-third";
        $class_links_nav = "two-thirds";
        $class_nav = "six-items";
        break;
    case Rights::$ADMIN:
        $class_links_header = "one-third";
        $class_links_nav = "two-thirds";
        $class_nav = "six-items";
        break;
    default:
        $class_links_header = "semi";
        $class_links_nav = "semi";
        $class_nav = "four-items";
        break;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <base href="<?php echo root; ?>/">
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="icon" href="Images/Logos/favicon.ico"/>
        <script type="text/javascript" src="js/main.js"></script>
	<?php foreach ($js_array as $fichier) : ?>
        <script type="text/javascript" src="js/<?php echo $fichier; ?>.js"></script>
        <?php endforeach; ?>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/style_film.css" />
        <link rel="stylesheet" type="text/css" href="css/tables.css" />
        <link rel="stylesheet" type="text/css" href="css/mobile.css" />
        <title> <?php echo $titre_page; ?> </title>
    </head>

    <body onload="onload();">
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
        
