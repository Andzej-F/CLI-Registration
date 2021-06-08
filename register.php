<?php

echo "\033[0;35m Registration Page\n \033[0m";
echo "To exit the application press X\n";
echo "Please enter the following information about you: X\n";

while (1) {
    while (1) {
        $name = readline("Name and surname:\n");
        if (!is_null(valName($name)))
            break;
    }

    while (1) {
        $email = readline("Email:\n");
        if (!is_null(valEmail($email)))
            break;
    }

    while (1) {
        $phone = readline("Phone number (8 digits):\n");
        if (!is_null(valNumber($phone)))
            break;
    }

    while (1) {
        $nin = readline("National ID number (8 digits):\n");
        if (!is_null(valNumber($nin)))
            break;
    }

    while (1) {
        $date = readline("Date (in format MM:YY):\n");
        if (!is_null(valDate($date)))
            break;
    }

    while (1) {
        $time = readline("Time (in format HH:MM):\n");
        if (!is_null(valTime($time)))
            break;
    }
    break;
}
/* ----- Validation functions ----- */

/* Validate user' name and surname input */
function valName($name): ?string
{
    /* If user pressed X, redirect to the main page */
    if ($name === 'X') {
        require_once "main.php";
        exit();
    }

    /* If the name field is not empty, proceed with the validation */
    if (isset($name)) {

        /* Check name and surname length */
        $nameLength = mb_strlen($name);
        if (($nameLength > 64)) {
            echo ("\033[01;31m Error: input cannot be longer than 64 characters\n \033[0m");
            return NULL;
        }
        /* Check if name and surname begin with a capital letters */
        if ($name != ucwords($name, " \t\r\n\f\v")) {
            echo ("\033[01;31m Error: name and surname must begin with capital letters\n \033[0m");
            return NULL;
        }
        /* Check that the input contains alpha characters and special characters (space, apostrophe, hyphen) */
        if (!preg_match('/^[a-zA-z \'-]+$/i', $name)) {
            echo ("\033[01;31m Error: input must consist of alpha characters\n \033[0m");
            return NULL;
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }
    /* If everythink is OK, return $name value */
    return $name;
}

/* Validate user' name and surname input */
function valEmail($email): ?string
{
    /* If user pressed X, redirect to the main page */
    if ($email === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check email value with filter_ver function */
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        echo ("\033[01;31m Error: not valid email address\n \033[0m");
        return NULL;
    }

    /* If everythink is OK, return $email value */
    return $email;
}

/* Validate user' number input */
function valNumber($number): ?string
{
    /* If user pressed X, redirect to the main page */
    if ($number === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check if the number is entered */
    if (isset($number)) {
        /* Check if number value is 8 characters long */
        $numberLength = mb_strlen($name);
        if (($numberLength != 8)) {
            echo ("\033[01;31m Error: number must be 8 digits long\n \033[0m");
            return NULL;
        }

        /* Check if the number value is of integer type */
        if (filter_var($number, FILTER_VALIDATE_INT) === FALSE) {
            echo ("\033[01;31m Error: please enter an integer value\n \033[0m");
            return NULL;
        } else {
            /* Check if it is positive */
            if ($number < 0) {
                echo ("\033[01;31m Error: the value cannot be negative value\n \033[0m");
                return NULL;
            }
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* If everythink is OK, return $number value */
    return $number;
}

/* Validate user's date input */
function valDate($date): ?string
{
    /* If user pressed X, redirect to the main page */
    if ($date === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check if the date is entered */
    if (isset($date)) {
        /* Check if date input string ("MM-DD") is 5 characters long */
        $dateStringLength = mb_strlen($date);
        if (($dateStringLength != 5)) {
            echo ("\033[01;31m Error: date format must be MM-DD\n \033[0m");
            return NULL;
        }
        /* Get the month and day values from $date input */
        $date = explode("-", $date);

        /* Set the month value */
        $month = $date[0];

        /* Set the day value */
        $day = $date[1];

        /* Check month value */
        if ($month < 1 || $month > 12) {
            echo ("\033[01;31m Error: month value must be between 1 and 12\n \033[0m");
            return NULL;
        }

        /* Initialise current year value */
        $currentYear = date("Y");

        /* Set the given month's days value */
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);

        /* Check day value */
        if ($day < 1 || $day > $daysInCurrentMonth) {
            echo ("\033[01;31m Error: day value must be between 1 and $daysInCurrentMonth\n \033[0m");
            return NULL;
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* Change the input date format from "MM-DD" to "YYYY-MM-DD" */
    $date = $currentYear . '-' . $date;

    /* If everythink is OK, return $date value in "YYYY-MM-DD" format */
    return $date;
}

/* Validate user's time input */
function valTime($time): ?string
{
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

        /* Get the hour and minute values from $time input */
        $time = explode(":", $time);

        /* Set the hour value */
        $hour = $time[0];

        /* Set the minute value */
        $minute = $time[1];

        /* Check hour value, that is 08:00 to 17:00 ("Working hours")*/
        if ($hour < 8 || $hour > 17) {
            echo ("\033[01;31m Error: hour value must be between 08:00 and 17:00\n \033[0m");
            return NULL;
        }

        /* Initialise current year value */
        $currentTime = date("H:m:i");

        /* Set the given month's days value */
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);

        /* Check day value */
        if ($day < 1 || $day > $daysInCurrentMonth) {
            echo ("\033[01;31m Error: day value must be between 1 and $daysInCurrentMonth\n \033[0m");
            return NULL;
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* Change the input time format from "HH:MM" to "YYYY-HH:MM" */
    $time = $currentYear . '-' . $time;

    /* If everythink is OK, return $time value in "YYYY-HH:MM" format */
    return $time;
}

    /* Check if another user is not registered on the same date and time */

    /* After successful validation write user's data to the database */


    /* Redirect user to "user settings" */
