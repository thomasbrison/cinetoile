<select name="droits">
    <option value="<?php echo Rights::$BASIC; ?>" <?php if (isset($droits) && $droits === Rights::$BASIC) echo "selected"; ?>>Étudiant</option>
    <option value="<?php echo Rights::$MEMBER; ?>" <?php if (isset($droits) && $droits === Rights::$MEMBER) echo "selected"; ?>>Membre</option>
    <option value="<?php echo Rights::$ADMIN; ?>" <?php if (isset($droits) && $droits === Rights::$ADMIN) echo "selected"; ?>>Admin</option>
</select>
