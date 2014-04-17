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

/**
 * Append a message in the stack.
 * Deliver it with display_message();
 * @param string $msg The message to deliver
 * @param int $time The time in ms it should appear
 */
function create_message($msg, $time = 3000) {
    if (empty($_SESSION['MESSAGE'])) {
        $_SESSION['MESSAGE'] = array();
        $_SESSION['MESSAGE']['CONTENT'] = "";
        $_SESSION['MESSAGE']['DURATION'] = 0;
    } else {
        $_SESSION['MESSAGE']['CONTENT'] .= "\n";
    }
    $_SESSION['MESSAGE']['CONTENT'] .= $msg;
    $_SESSION['MESSAGE']['DURATION'] += $time;
}

/**
 * Return the message stack and empty it.
 * @return array If there is a message, the key 'content' contains the content of the message and the key 'duration' contains the duration of the message. If there is no message, return NULL; 
 */
function get_message() {
    if (!isset($_SESSION['MESSAGE'])) {
        return NULL;
    }
    $array = array(
        'content' => $_SESSION['MESSAGE']['CONTENT'],
        'duration' => $_SESSION['MESSAGE']['DURATION']
    );
    unset($_SESSION['MESSAGE']);
    return $array;
}

/**
 * Append the message to the current HTML.
 */
function append_message() {
    $msg_array = get_message();
    if ($msg_array != NULL) {
        $msg = $msg_array['content'];
        $duration = $msg_array['duration'];
        echo "<nav id='message' js-timeout='$duration'>$msg</nav>";
    }
}
