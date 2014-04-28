<?php

function telephone_format($tel) {
    if ($tel) {
        return substr($tel, 0, 2) . '.' . substr($tel, 2, 2) . '.' . substr($tel, 4, 2) . '.' . substr($tel, 6, 2) . '.' . substr($tel, 8, 2);
    } else {
        return null;
    }
}

?>
