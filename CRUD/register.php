<?php
/* TODO require_once('functions.php') */
require_once './db_inc.php';

echo "\033[0;35m Registration Page\n \033[0m";
echo "To exit the application press X\n";
echo "Please enter the following information about you: X\n";

while (1) {
    while (1) {
        $input = readline("Name and surname:");
        $name = valName($input);
        if (!is_null($name))
            break;
    }

    while (1) {
        $input = readline("Email:");
        $email = valEmail($input);
        if (!is_null($email))
            break;
    }

    while (1) {
        $input = readline("Phone number (8 digits) +370:");
        $phone = valNumber($input);
        if (!is_null(valNumber($phone)))
            break;
    }

    while (1) {
        $input = readline("National ID number (8 digits):");
        /* TODO valNin($input)*/
        $nin = valNumber($input);
        if (!is_null(valNumber($nin)))
            break;
    }

    while (1) {
        $input = readline("Preferred appointment date (MM-YY):");
        $date = valDate($input);
        if (!is_null($date)) {
            break;
        }
    }

    while (1) {
        $input = readline("Time (written in format HH:MM):");
        $time = valTime($input, $date);
        if (!is_null($time))
            break;
    }
    break;
}

/* After successful validation write user's data to the database */
/* Insert query template */
$query = 'INSERT INTO users (name, email, phone, nin, date_and_time)
                  VALUES (:name, :email, :phone, :nin, :date_and_time)';

/* Values array for PDO */
$date_and_time = $date . ' ' . $time;
$values = [
    ':name' => $name,
    ':email' => $email,
    ':phone' => $phone,
    ':nin' => $nin,
    ':date_and_time' => $date_and_time
];

/* Execute the query */
print_r(get_defined_vars());
try {
    $res = $pdo->prepare($query);
    $res->execute($values);
} catch (PDOException $e) {
    /* If there is a PDO exception, throw a standard exception */
    throw new Exception("\033[01;31m Error: Database query error 73\n \033[0m");
}

/* Redirect user to "user settings" */
echo 'User successfully registered\n';
require_once 'user_settings.php';
exit();


/* ----- Validation functions ----- */
/*TODO move those functions to separate folder functions.php */
/* Validate user name and surname */
function valName($name): ?string
{
    /* Remove extra spaces */
    $name = trim($name);

    /* If user pressed X, redirect to the main page */
    if ($name === 'X') {
        require_once "main.php";
        exit();
    }

    /* If the name field is not empty, proceed with the validation */
    if (isset($name)) {

        /* Check name and surname length */
        $nameLength = mb_strlen($name);
        if (($nameLength < 3 || $nameLength > 64)) {
            echo ("\033[01;31m Error: input must be 3 to 64 characters long\n \033[0m");
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

/* Validate user email */
function valEmail($email): ?string
{
    /* Remove extra spaces */
    $email = trim($email);

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

    /* TODO check if the same email already exists in the database */

    /* If everythink is OK, return $email value */
    return $email;
}

/* Validate user' number input */
function valNumber($number): ?string
{
    /* Remove extra spaces */
    $number = trim($number);

    /* If user pressed X, redirect to the main page */
    if ($number === 'X') {
        require_once "main.php";
        exit();
    }

    /* Check if the number is entered */
    if (isset($number)) {
        /* Check if number value is 8 characters long */
        $numberLength = mb_strlen($number);
        if (($numberLength != 8)) {
            echo ("\033[01;31m Error: number must be 8 digits long\n \033[0m");
            return NULL;
        }
        /* Check if the input has numeric values */
        if (!ctype_digit($number)) {
            echo ("\033[01;31m Error: please enter number only\n \033[0m");
            return NULL;
        }
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* If everythink is OK, return $number value */
    return $number;
}

/* TODO 
create another function chekNIN copy paste checkNbr and add
check if the same nin numer already exists in the database */

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

/* Validate user's time input */
function valTime($time, $appointmentDay): ?string
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

        /* Today's date YYYY-MM-DDD */
        $today = date("Y-m-d");

        /* Time right now HH:MM:SS */
        $timeNow = date("H:i:s");

        /* Modify appointment time in format HH:MM:00 */
        $time = $time . ':00';

        /* If appointment day is today, make sure that the user will not
           set the time in the past or out of working hours*/
        if ($appointmentDay == $today) {

            /* $opening and $closing hours */
            $opening = "08:00:00";
            $closing = "17:00:00";

            /* If the user thries to register after closing time, redirect to the main page */
            if ($time > $closing) {
                echo ("\033[01;31m Sorry no appointments available for today, please register for another day\n \033[0m");
                require_once('./main.php');
                exit();
            }

            /* If the user thries to register after closing time, redirect to the main page */
            if ($timeNow < $opening) {
                echo ("\033[01;31m Error: registration hours are $opening - $closing\n \033[0m");
                return NULL;
            }

            if ($timeNow > $time) {
                echo ("\033[01;31m Error: this time has already passed\n \033[0m");
                return NULL;
            }
        }

        /* Get the hour and minute values from $time input */
        $array = explode(":", $time);

        /* Set the hour value */
        $hour = (int)$array[0];

        /* Set the minute value */
        $minute = (int)$array[1];

        /* Set work start and end hours */
        $opening = "8";
        $closing = "17";

        /* Check hour value, that is 08:00 to 17:00 ("Working hours")*/
        if ($hour < $opening || $hour > $closing) {
            echo ("\033[01;31m Error: Registration hours are $opening - $closing\n \033[0m");
            return NULL;
        }

        /* Check minute value, that is 0 to 59*/
        if ($minute < 0 || $minute > 59) {
            echo ("\033[01;31m Error: wrong minute value\n \033[0m");
            return NULL;
        }

        /*TODO This function should be at the end, after other validations
          Check is somebody else is not registered for that time */
    } else {
        echo ("\033[01;31m Error: this field cannot be empty\n \033[0m");
        return NULL;
    }

    /* If everythink is OK, return $time value in "YYYY-HH:00" format */
    return $time;
}