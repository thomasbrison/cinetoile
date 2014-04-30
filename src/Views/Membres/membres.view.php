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
                if (isset($ecole) && $ecole === "Ense3") {
                    $ecole = "Ense<sup>3</sup>";
                }
                $annee = annee_format($membre->getAnnee());
                $droits = $membre->getDroits();
                switch ($droits) {
                    case Rights::BASIC:
                        $droit = "Étudiant";
                        break;
                    case Rights::MEMBER:
                        $droit = "Membre";
                        break;
                    case Rights::ADMIN:
                        $droit = "Admin";
                        break;
                }
                ?>
                <tr>
                    <td class="numero"> <?php echo $numero; ?> </td>
                    <td class="login"> <?php echo $login; ?> </td>
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
                    <td class="droits lien">
                        <span class="js-el" onclick="displaySelections(this);"> <?php echo $droit; ?> </span>
                        <form method="GET" action="<?php echo Routes::membersUpdateRights; ?>" class="hidden" onsubmit="return changerDroits(this);">
                            <input type="hidden" name="login" value="<?php echo $login; ?>">
                            <?php include 'Templates/selection_droits.php'; ?>
                            <input type="submit">
                        </form>
                    </td>
                    <td class="modif-suppr">
                        <div class="inline invisible">
                            <form class="inline" name="modifier_membre" method="GET" action="<?php echo Routes::membersUpdate; ?>">
                                <input type="hidden" name="login" value="<?php echo $login; ?>"/>
                                <input type="submit" value="Modifier"/>
                            </form>
                        </div>
                        <div class="inline invisible">
                            <form class="inline" name="supprimer_membre" method="GET" action="<?php echo Routes::membersDelete; ?>" onsubmit="return removeMembre(this);">
                                <input type="hidden" name="login" value="<?php echo $login; ?>"/>
                                <input type="button" value="Supprimer" onclick="confirm(this);"/>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<br/><a href="mailto:?bcc=<?php echo $emails; ?>">Envoyer un email à tout le monde</a>
<br/><a href="mailto:?bcc=<?php echo $membersEmails; ?>">Envoyer un email aux membres</a>

<div class="options">
    <a class="button" href="<?php echo Routes::membersCreate; ?>">Ajouter un membre</a>
</div>