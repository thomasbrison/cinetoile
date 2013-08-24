<?php
/*
 * Vue des membres
 */

require_once 'Lib/annee-scolaire.php';
require_once 'Lib/telephone.php';
?>

<section id="tableMembres">
    <table class="membres">
        <caption>Membres</caption>

        <thead>
            <tr>
                <th class="numero"> &nbsp; </th>
                <th class="login"> Login </th>
                <th class="prenom"> Pr&eacute;nom </th>
                <th class="nom"> Nom </th>
                <th class="coordonnees"> Coordonn&eacute;es </th>
                <th class="ecole"> &Eacute;cole </th>
                <th class="annee"> Ann&eacute;e </th>
                <th class="droits"> Droits </th>
                <th class="modif-suppr"> &nbsp; </th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($membres as $numero => $membre) :
                $numero = $numero + 1;
                $login = $membre->getLogin();
                $prenom = $membre->getPrenom();
                $nom = $membre->getNom();
                $email = $membre->getEmail();
                $tel = telephone_format($membre->getTelephone());
                $ecole = $membre->getEcole();
                if (isset($ecole) && $ecole == "Ense3") {
                    $ecole = "Ense<sup>3</sup>";
                }
                $annee = annee_format($membre->getAnnee());
                $droits = $membre->getDroits();
                switch ($droits) {
                    case "1":
                        $droit = "Membre";
                        break;
                    case "2":
                        $droit = "Admin";
                        break;
                }
                ?>
                <tr>
                    <td class="numero"> <?php echo $numero; ?> </td>
                    <td class="login" id="login<?php echo $numero ?>"> <?php echo $login; ?> </td>
                    <td class="prenom"> <?php echo $prenom; ?> </td>
                    <td class="nom"> <?php echo $nom; ?> </td>
                    <td class="coordonnees">
                        <?php if ($email && $tel) : ?>
                            <ul>
                                <li><?php echo $email ?></li>
                                <li><?php echo $tel ?></li>
                            </ul>
                            <?php
                        else :
                            echo "$email" . "$tel";
                        endif;
                        ?>
                    </td>
                    <td class="ecole"> <?php echo $ecole; ?> </td>
                    <td class="annee"> <?php echo $annee; ?> </td>
                    <td class="droits lien" id="droits<?php echo $numero ?>" onclick="modifier_droits(<?php echo $numero; ?>);"> <?php echo $droit; ?> </td>
                    <td class="modif-suppr" id="modifsuppr<?php echo $numero ?>">
                        <div class="inline hidden" id="modif<?php echo $numero ?>">
                            <form class="inline" name="modifier_membre" method="GET" action="membres.php/modifier">
                                <input type="hidden" name="login" value="<?php echo $login; ?>"/>
                                <input type="submit" value="Modifier"/>
                            </form>
                        </div>
                        <div class="inline hidden" id="suppr<?php echo $numero ?>">
                            <form class="inline" name="supprimer_membre" method="GET" action="membres.php/supprimer" style="">
                                <input type="hidden" name="login" value="<?php echo $login; ?>"/>
                                <input type="button" value="Supprimer" id="confirme_suppr<?php echo $numero; ?>" onclick="confirme_suppression(<?php echo $numero; ?>);"/>
                                <input type="hidden" value="Oui" id="supprimer<?php echo $numero; ?>"/>
                                <input type="hidden" value="Non" id="annuler_suppr<?php echo $numero; ?>"/>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<br/><a href="mailto:<?php echo $emails; ?>">Envoyer un email aux membres</a>

<div class="options">
    <a class="button" href="membres.php/ajouter">Ajouter un membre</a>
</div>