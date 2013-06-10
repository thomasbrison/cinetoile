<section id="main">

    <h2> Connexion </h2>

    <form name="authentification" method="post">

        <fieldset>
            <p>
                <label form="authentification">Login :  </label>
                <input type="text" name="login" size="32" maxlength="32" required autofocus/>
            </p>
            <p>
                <label form="authentification">Mot de passe :  </label>
                <input type="password" name="password" size="25" maxlength="32" required/>
                <!--keygen style="display: none" name="security" keytype="rsa" challenge-->
            </p>
        </fieldset>

        <p id="boutons">
            <input type="submit" name="connexion" value="Connexion" />
            <input type="reset" name="annuler" value="Annuler" />
        </p>

    </form>

</section>