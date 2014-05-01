<?php

function file_upload($file, $sizemax, $valid_extensions, $final_dir) {
    $array_file = $_FILES[$file];
    $file_name_without_accents = strtr($array_file['name'], 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $formatted_file_name = preg_replace('/([^.-a-z0-9]+)/i', '_', $file_name_without_accents);
    if (isset($array_file) AND $array_file['error'] === UPLOAD_ERR_OK) {
        $upload = file_upload_success($array_file, $sizemax, $valid_extensions, __DIR__ . "/../../public/" . $final_dir, $formatted_file_name);
    } else {
        $message = file_upload_error_message($array_file, $formatted_file_name);
        $upload = file_upload_summary(FALSE, $array_file, $message, $formatted_file_name);
    }
    return $upload;
}

function file_upload_success($array_file, $sizemax, $valid_extensions, $final_dir, $formatted_file_name) {
    $size = filesize($array_file['tmp_name']);
    if ($size <= $sizemax) {
        $upload = file_upload_correct_size($array_file, $valid_extensions, $final_dir, $formatted_file_name);
    } else {
        $message = "Envoi limit&eacute &agrave $sizemax o.";
        $upload = file_upload_summary(FALSE, $array_file, $message, $formatted_file_name);
    }
    return $upload;
}

function file_upload_correct_size($array_file, $valid_extensions, $final_dir, $formatted_file_name) {
    $file_info = pathinfo($array_file['name']);
    $extension = $file_info['extension'];
    if (in_array($extension, $valid_extensions)) {
        $upload = file_upload_valid_extension($array_file, $final_dir, $formatted_file_name);
    } else {
        $message = "Extension $extension non autoris&eacutee.";
        $upload = file_upload_summary(FALSE, $array_file, $message, $formatted_file_name);
    }
    return $upload;
}

function file_upload_valid_extension($array_file, $final_dir, $formatted_file_name) {
    $success = TRUE;
    $message = "L'envoi du fichier $formatted_file_name a bien &eacutet&eacute effectu&eacute !";
    if (!file_exists($final_dir . $formatted_file_name)) {
        mkdir($final_dir, 0777, TRUE);
        $success = move_uploaded_file($array_file['tmp_name'], $final_dir . $formatted_file_name);
    }
    if (!$success) {
        $message = "Erreur lors de l'&eacutecriture du fichier $formatted_file_name. Le r&eacutepertoire $final_dir n'est peut-&ecirctre pas libre en &eacutecriture.";
    }
    return file_upload_summary($success, $array_file, $message, $formatted_file_name);
}

function file_upload_error_message($array_file, $formatted_file_name) {
    $message = "Erreur lors de l'envoi du fichier $formatted_file_name : ";
    switch ($array_file['error']) :
        case UPLOAD_ERR_INI_SIZE :   // 1
            $message .= "le fichier d&eacutepasse la limite autoris&eacutee par le serveur.";
            break;
        case UPLOAD_ERR_FORM_SIZE :   // 2
            $message .= "le fichier d&eacutepasse la limite autoris&eacutee dans le formulaire.";
            break;
        case UPLOAD_ERR_PARTIAL :   // 3
            $message .= "l'envoi du fichier a &eacutet&eacute interrompu pendant le transfert.";
            break;
        case UPLOAD_ERR_NO_FILE :   // 4
            $message .= "le fichier a une taille nulle.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR :    // 6
            $message .= "absence de r&eacutepertoire temporaire.";
            break;
        case UPLOAD_ERR_CANT_WRITE :   // 7
            $message .= "&eacutecriture impossible.";
            break;
        case UPLOAD_ERR_EXTENSION :   // 8
            $message .= "mauvaise extension.";
            break;
    endswitch;
    return $message;
}

function file_upload_summary($success, $array_file, $message, $formatted_file_name) {
    $upload = array(
        'success' => $success,
        'error' => $array_file['error'],
        'message' => utf8_decode($message),
        'file_name' => $formatted_file_name
    );
    return $upload;
}

?>
