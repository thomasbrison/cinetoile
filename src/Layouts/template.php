<?php
if (!isset($titre_page)) {
    $titre_page = "Ciné'toile - Grenoble INP";
} else {
    $titre_page = $titre_page . " - Ciné' toile";
}

switch ($_SESSION['droits']) {
    case Rights::MEMBER:
        $class_links_header = "one-third";
        $class_links_nav = "two-thirds";
        $class_nav = "six-items";
        break;
    case Rights::ADMIN:
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
        <script type="text/javascript" src="js/cinetoile.js"></script>
        <script type="text/javascript" src="js/facebook.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/style_film.css" />
        <link rel="stylesheet" type="text/css" href="css/tables.css" />
        <link rel="stylesheet" type="text/css" href="css/mobile.css" />
        <title> <?php echo $titre_page; ?> </title>
    </head>

    <body onload="onload();">
        <?php include 'header.php'; ?>

        <section id="main">
            <?php include $view; ?>
        </section>

        <?php
        append_message();
        include 'footer.php';
        ?>
    </body>
</html>