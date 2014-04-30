<?php

/**
 * Description of Loader
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
class Loader {

    public static function autoload() {
        spl_autoload_register(function($class) {
            if (is_int(strpos($class, "Controller"))) {
                include_once 'Controllers/' . $class . '.class.php';
            } elseif (is_int(strpos($class, "Table"))) {
                include_once 'Tables/' . $class . '.class.php';
            } else {
                include_once 'Beans/' . $class . '.class.php';
            }
        });
    }

}
