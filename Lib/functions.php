<?php

/**
 * Format an input string
 * @param string $str
 * @return The formatted string, or NULL if str is empty or equals 'NULL'
 */
function parse_input($str) {
    if (empty($str) || $str === 'NULL') {
        return NULL;
    }
    return addslashes($str);
}
