<select name="ecole">
    <option value=NULL <?php if (!isset($ecole)) echo "selected"; ?>>Choisir l'&eacute;cole</option>
    <option value="Ense3" <?php if (isset($ecole) && $ecole === "Ense3") echo "selected"; ?>>Ense3</option>
    <option value="Ensimag" <?php if (isset($ecole) && $ecole === "Ensimag") echo "selected"; ?>>Ensimag</option>
    <option value="GI" <?php if (isset($ecole) && $ecole === "GI") echo "selected"; ?>>Génie Industriel</option>
    <option value="Pagora" <?php if (isset($ecole) && $ecole === "Pagora") echo "selected"; ?>>Pagora</option>
    <option value="Phelma" <?php if (isset($ecole) && $ecole === "Phelma") echo "selected"; ?>>Phelma</option>
    <option value="Autre" <?php if (isset($ecole) && $ecole === "Autre") echo "selected"; ?>>Autre</option>
</select>