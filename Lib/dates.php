<?php

function date_format_month_to_string($month_number) {
    switch ($month_number) {
        case 1 :
            $month = "Janvier";
            break;
        case 2 :
            $month = "Février";
            break;
        case 3 :
            $month = "Mars";
            break;
        case 4 :
            $month = "Avril";
            break;
        case 5 :
            $month = "Mai";
            break;
        case 6 :
            $month = "Juin";
            break;
        case 7 :
            $month = "Juillet";
            break;
        case 8 :
            $month = "Août";
            break;
        case 9 :
            $month = "Septembre";
            break;
        case 10 :
            $month = "Octobre";
            break;
        case 11 :
            $month = "Novembre";
            break;
        case 12 :
            $month = "Décembre";
            break;
    }
    return $month;
}

function date_format_to_string($datetime) {
    $date_diff = date("d m Y H i", strtotime($datetime));
    $numero_mois = substr($datetime, 3, 2);
    $mois = date_format_month_to_string($numero_mois);
    $date_format = substr_replace($date_diff, 'H', 13, 1);
    $date_sans_mois = substr($date_format, 0, 10);
    $heure = substr($date_format, 11, 5);
    $date = substr_replace($date_sans_mois, $mois, 3, 2);
    return array('date' => $date, 'heure' => $heure);
}

/**
 * Returns an array containing the current school year
 * The key "first_year" contains the first year of the period, finishing in July
 * The key "second_year" contains the second year of the period, beginning in August
 * @return array
 */
function date_get_school_year() {
    $current_date = getdate();
    $current_year = $current_date['year'];
    $current_month = $current_date['mon'];
    $years = array();
    $years['first_year'] = ($current_month < 8) ? ($current_year - 1) : $current_year;
    $years['second_year'] = $years['first_year'] + 1;
    return $years;
}

?>
