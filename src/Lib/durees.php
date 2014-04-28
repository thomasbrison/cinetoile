<?php

function duree_format_duree($duree) {
    if (!$duree) {
        return NULL;
    } else {
        return substr_replace(substr($duree, 1, 4), 'h', 1, 1);
    }
}

?>
