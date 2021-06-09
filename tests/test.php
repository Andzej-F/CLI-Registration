<?php

/* Name inputs */
$inputs = [
    "06-09",
    "---07",
    "06:07",
    "06 07",
    "06a07",
    "06-09",
    "05-09",
    "00-00",
    "01-03",
    "1,-03",
    "06-10",
    "12-10",
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
    "08:00",
    "17:00",
    " 18:01 ",
];

foreach ($inputs as $input) {
    $result = valTime($input);
    if (!is_null(valTime($input))) {
        echo ("\033[0;32m Success: $input is valid\n\033[0m");
        echo ("\033[0;33m Return type of $input is $result\n\n\033[0m");
    } else {
        echo ("\033[01;31mKlaida: input $input is not valid\n\033[0m");
        echo "\033[01;31mReturn type of $input is $result\n\033[0m";
    }
    echo "===========================================\n\n";
}

/* Validate user's time input */
function valTime($time): ?string
{
    /* Remove extra spaces */
    $time = trim($time);

    /* If user pressed X, redirect to the main page */
    if ($time === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check if the time value is entered */
    if (isset($time)) {

        /* Check if time input string ("HH:MM") is 5 characters long */
        $timeStringLength = mb_strlen($time);
        if (($timeStringLength != 5)) {
            echo ("\033[01;31m Error: time format must be HH:MM\n \033[0m");
            return NULL;
        }

        /* Check time format */
        if (strtotime($time) === FALSE) {
            echo ("\033[01;31m Error: not valid time\n \033[0m");
            return NULL;
        }

        /* Get the hour and minute values from $time input */
        $array = explode(":", $time);

        /* Set the hour value */
        $hour = (int)$array[0];

        /* Set the minute value */
        $minute = (int)$array[1];

        /* Check hour value, that is 08:00 to 17:00 ("Working hours")*/
        if ($hour < 8 || $hour > 17) {
            echo ("\033[01;31m Error: hour value must be between 08:00 and 17:00\n \033[0m");
            return NULL;
        }

        /* Check minute value, that is 0 to 59 ("Working hours")*/
        if ($minute < 0 || $minute > 59) {
            echo ("\033[01;31m Error: wrong minute value\n \033[0m");
            return NULL;
        }

        /* Today's date YYYY-MM-DDD */
        $today = date("Y-m-d");

        /* Get the appointment date 
        //TODO check how to get today's date
        */
        $appointmentDay = "2021-06-09";

        /* Time right now HH:MM:SS */
        $timeNow = date("H:i:s");

        /* Modify appointment time in format HH:MM:00 */
        $time = $time . ':00';

        /* If appointment day is today, make sure that the user will not set the time in the past */
        if ($appointmentDay == $today) {
            if ($timeNow > $time) {
                echo ("\033[01;31m Error: appointment time is set in the past\n \033[0m");
                return NULL;
            }
        }

        /*TODO This function shoul be at the end, after other validations
          Check is somebody else is not registered for that time */
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* If everythink is OK, return $time value in "YYYY-HH:00" format */
    return $time;
}
