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
    $mon_nb = date("n", strtotime($datetime));
    $mon = date_format_month_to_string($mon_nb);
    $date_format = substr_replace($date_diff, 'H', 13, 1);
    $date_sans_mois = substr($date_format, 0, 10);
    $time = substr($date_format, 11, 5);
    $date = substr_replace($date_sans_mois, $mon, 3, 2);
    return array('date' => $date, 'time' => $time);
}

/**
 * Returns an array containing the school year of a date
 * The key "first_year" contains the first year of the period, finishing in July
 * The key "second_year" contains the second year of the period, beginning in August
 *
 * @param int $year
 * @param int $month
 * @return array
 */
function date_get_school_year($year, $month) {
    $years = array();
    $years['first_year'] = ($month < 8) ? ($year - 1) : $year;
    $years['second_year'] = $years['first_year'] + 1;
    return $years;
}

/**
 * Returns an array containing the current school year
 * The key "first_year" contains the first year of the period, finishing in July
 * The key "second_year" contains the second year of the period, beginning in August
 *
 * @return array
 */
function date_get_current_school_year() {
    $date = getdate();
    $year = $date['year'];
    $month = $date['mon'];
    return date_get_school_year($year, $month);
}

function date_get_school_year_from_datetime($datetime) {
    $date = new DateTime($datetime);
    $year = $date->format('Y');
    $month = $date->format('m');
    return date_get_school_year($year, $month);
}

?>
