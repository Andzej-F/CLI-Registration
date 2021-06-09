<?php

/* Name inputs */
$inputs = [
    // "06-09",
    // "---07",
    // "06:07",
    // "06 07",
    // "06a07",
    // "06-09",
    // "05-09",
    // "00-00",
    // "01-03",
    // "1,-03",
    // "06-10",
    // "12-10",
    "13-10",
    "13-31",
    "12-32",
    "2-32",
    "2-29",
    " 02-29 ",
    "0a-29",
    "0a-29",
    "01-29",
    "06-29",
    "06-32",
    "07-31",
];

foreach ($inputs as $input) {
    $result = valDate($input);
    if (!is_null(valDate($input))) {
        echo ("\033[0;32m Success: $input is valid\n\033[0m");
        echo ("\033[0;33m Return type of $input is $result\n\n\033[0m");
    } else {
        echo ("\033[01;31mKlaida: input $input is not valid\n\033[0m");
        echo "\033[01;31mReturn type of $input is $result\n\033[0m";
    }
    echo "===========================================\n\n";
}

/* Validate user's date input */
function valDate($regDate): ?string
{
    /* Remove extra spaces */
    $regDate = trim($regDate);

    /* If user pressed X, redirect to the main page */
    if ($regDate === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check if the date is entered */
    if (isset($regDate)) {

        /* Check if date input string ("MM-DD") is 5 characters long */
        $regDateLength = mb_strlen($regDate);
        if (($regDateLength != 5)) {
            echo ("\033[01;31m Error: wrong date format\n \033[0m");
            return NULL;
        }

        /* Current year value */
        $year = date("Y");

        /* Change the input date format from "MM-DD" to "YYYY-MM-DD" */
        $regDate = $year . '-' . $regDate;

        /* Check date format */
        if (strtotime($regDate) === FALSE) {
            echo ("\033[01;31m Error: date doesn't exist\n \033[0m");
            return NULL;
        }

        /* Get the month and day values from $regDate input */
        $value = explode("-", $regDate);

        /* Set the month value */
        $month = (int)$value[1];

        /* Set the day value */
        $day = (int)$value[2];

        /* Set today variable in YYYY-MM-DD format*/
        $today = date("Y-m-d");

        /* Check month value */
        if (($month < 1) || ($month > 12)) {
            echo ("\033[01;31m Error: month value must be between 1 and 12\n \033[0m");
            return NULL;
        }

        /* Check if the appointment date is not set in the past*/
        if (strtotime($regDate) < strtotime($today)) {
            echo ("\033[01;31m Error: date set in the past\n \033[0m");
            return NULL;
        }

        /* Set the given month's days value */
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        /* Check day value */
        if ($day < 1 || $day > $daysInCurrentMonth) {
            echo ("\033[01;31m Error: day value must be between 1 and $daysInCurrentMonth\n \033[0m");
            return NULL;
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }
    /* If everythink is OK, return $registration date */
    return $regDate;
}
