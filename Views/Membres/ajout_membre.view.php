<?php
/*
 * Vue pour l'ajout d'un membre
 */
?>

<form class="formulaire" name="ajout_membre" method="post">

    <fieldset>
        <legend>Informations sur le membre</legend>
        <p>
            <label>Login :  </label>
            <input type="text" name="login" size="25" maxlength="32" placeholder="Login - sans accents" pattern="[A-za-z]+" required autofocus/>
        </p> 
        <p>
            <label>Mot de passe : </label>
            <input type="password" name="password" size="25" maxlength="64" placeholder="Mot de passe" required/>
        </p>
        <input type="hidden" name="droits" value="1"/>
        <p>
            <label>Pr&eacute;nom : </label>
            <input type="text" name="prenom" size="25" maxlength="32" placeholder="Prénom" required/>
        </p>
        <p>
            <label>Nom : </label>
            <input type="text" name="nom" size="25" maxlength="32" placeholder="Nom"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>Coordon&eacute;es</legend>
        <p>
            <label>e-mail : </label>
            <input type="email" name="email" size="25" maxlength="64" placeholder="E-mail"/>
        </p>
        <p>
            <label>T&eacute;l&eacute;phone : </label>
            <input type="tel" name="tel1" size="1" maxlength="2" placeholder="06"/>
            .
            <input type="tel" name="tel2" size="1" maxlength="2" placeholder="00"/>
            .
            <input type="tel" name="tel3" size="1" maxlength="2" placeholder="00"/>
            .
            <input type="tel" name="tel4" size="1" maxlength="2" placeholder="00"/>
            .
            <input type="tel" name="tel5" size="1" maxlength="2" placeholder="00"/>
        </p>
    </fieldset>
    <br/>
    <fieldset>
        <legend>&Eacute;tudes</legend>
        <p>
            <label>&Eacute;cole : </label>
            <select name="ecole">
                <option value=NULL selected>Choisir l'&eacute;cole</option>
                <option value="Ense3">Ense3</option>
                <option value="Ensimag">Ensimag</option>
                <option value="GI">Génie Industriel</option>
                <option value="Pagora">Pagora</option>
                <option value="Phelma">Phelma</option>
                <option value="Autre">Autre</option>
            </select>
        </p>
        <p>
            <label>Ann&eacute;e : </label>
            <select name="annee">
                <option value=NULL selected>Choisir l'ann&eacute;e d'&eacute;tude</option>
                <option value="1">1A</option>
                <option value="2">2A</option>
                <option value="3">3A</option>
                <option value="Autre">Autre</option>
            </select>
        </p>
    </fieldset>

    <p id="boutons">
        <input type="submit" name="ajouter" value="Valider" />
        <input type="reset" name="reset" value="Reset"/>
        <button formaction="membres.php">Annuler</button>
    </p>

</form>
