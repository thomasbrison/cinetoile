<select name="annee">
    <option value=NULL <?php if (!isset($annee)) echo "selected"; ?>>
        Choisir l'ann&eacute;e d'&eacute;tude
    </option>
    <option value="1" <?php if (isset($annee) && $annee === "1") echo "selected"; ?>>1A</option>
    <option value="2" <?php if (isset($annee) && $annee === "2") echo "selected"; ?>>2A</option>
    <option value="3" <?php if (isset($annee) && $annee === "3") echo "selected"; ?>>3A</option>
    <option value="Autre" <?php if (isset($annee) && $annee === "Autre") echo "selected"; ?>>Autre</option>
</select>
