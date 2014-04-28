<?php

$login = $membre->getLogin();
$prenom = $membre->getPrenom();
$nom = $membre->getNom();
$email = $membre->getEmail();
$tel = $membre->getTelephone();
$tel1 = substr($tel, 0, 2);
$tel2 = substr($tel, 2, 2);
$tel3 = substr($tel, 4, 2);
$tel4 = substr($tel, 6, 2);
$tel5 = substr($tel, 8, 2);
$ecole = $membre->getEcole();
$annee = $membre->getAnnee();
$droits = $membre->getDroits();

$form_name = "modification_membre";
$form_action = "modifier";

if ($_SESSION['droits'] === Rights::$MEMBER) {
    $form_target = "profil.php";
} else {
    $form_target = "membres.php";
}

include 'Templates/formulaire.php';
?>
