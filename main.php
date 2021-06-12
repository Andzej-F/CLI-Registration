<?php
/* Get database connection script */
require_once('./db/db_inc.php');
/*

echo ("\033[01;31m Error: \n \033[0m");


Create an application that allows users to register for vaccination.
Users should be able to provide their personal information along with
preferred date and time for the appointment. 

In addition medical personnel
should be able to print a list of everybody registered for a particular date.

Application should be written in PHP and executed from CLI
(https://www.php.net/manual/en/features.commandline.usage.php).

Application should store these fields:
• ID
• Name
• Email
• Phone Number
• National identification number
• Date and Time

Application should have the following functionality
• V Add appointment
• Edit appointment
• Delete appointment

• Print list of appointment for specific date, sorted by time
Bonus points if you:
    
• Don’t use any framework
• Do validations (valid email, phone number, identification number)
• Add ability to import/export appointments in .csv format. 
  Example of .csv file should be added to repositor
 */
// require_once './functions.php';
// require_once './db/db_inc.php';

/*
    App design

 Main menu:
  -- register (to add appointment) 
    -- User settings page
        -- Edit appointment info
        -- Delete appointment date
        -- Go to main menu
  -- login
    -- user login
        -- User settings page
            -- Edit appointment info
            -- Delete appointment date
            -- Go to main menu
    -- med personnel login
        -- Show appointments
  -- exit the app
 */


showMainMenu();

/* ----------- CRUD frunctions-------------- */
/* Display main menu */
function showMainMenu()
{
    echo "\033[0;35m Registration for Vaccine Form\n \033[0m";
    echo "To proceed, choose the option\n";
    echo "1. Register for appointment\n";
    echo "2. Login to user account (to edit or delete appointment)\n";
    echo "3. Medical personnel login\n";
    echo "4. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            userRegister();
            break;
        case 2:
            login();
            break;
        case 3:
            // require_once('med_login.php');
            //exit();
        case 4:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showMainMenu();
    }
}

/* Add user data to the system */
function userRegister()
{
    echo "\033[0;35m Registration Page\n \033[0m";
    echo "To exit the application press X\n";
    echo "Please enter the following information about you: X\n";

    do {
        do {
            $input = readline("Name and surname:");
            $name = valName($input);
        } while (is_null($name));

        do {
            $input = readline("Email:");
            $email = valEmail($input);
        } while (is_null($email));

        do {
            $input = readline("Phone number (8 digits) +370:");
            $phone = valNumber($input);
        } while (is_null(valNumber($phone)));

        do {
            $input = readline("National ID number (8 digits):");
            /* TODO valNin($input)*/
            $nin = valNumber($input);
        } while (is_null(valNumber($nin)));

        do {
            $input = readline("Preferred appointment date (MM-YY):");
            $date = valDate($input);
        } while (is_null($date));

        do {
            $input = readline("Time (written in format HH:MM):");
            $time = valTime($input, $date);
        } while (is_null($time));

        $success = TRUE;
    } while (!$success);

    /* After successful validation write user's data to the database */

    global $pdo;

    /* Insert query template */
    $query = 'INSERT INTO users (name, email, phone, nin, date, time)
                  VALUES (:name, :email, :phone, :nin, :date, :time)';

    /* Values array for PDO */
    $values = [
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':nin' => $nin,
        ':date' => $date,
        ':time' => $time,
    ];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception("\033[01;31m Error: Database query error\n \033[0m");
    }
    /* After successful registration "redirect" to userSettings menu */
    echo "\033[01;32mYou have been successfully registered\n \033[0m";
    showUserSettings($email);
}

/* Display user settings options for registered or loginned users */
function showUserSettings($email)
{
    echo "\033[0;35m Welcome to User Settings Page\n \033[0m";
    echo "To proceed, choose the option\n";
    echo "1. Edit appointment\n";
    echo "2. Delete appointment\n";
    echo "3. Go to main menu\n";
    echo "4. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            showEditMenu($email);
            // require_once('edit.php');
            exit();
        case 2:
            require_once('delete.php');
            exit();
        case 3:
            require_once('main.php');
            exit();
        case 4:
            exit("Application closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showUserSettings($email);
    }
}

/* Edit menu function */
function showEditMenu($email)
{
    global $pdo;

    /* Select user data from the database */
    $query = "SELECT * FROM `users`
	          WHERE (email = :email)";

    /* Values array for PDO */
    $values = [':email' => $email];

    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
        $result = $res->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Database query error');
    }

    echo "\033[0;35m Choose the data fields you would like to edit\n \033[0m";
    echo "1. Name: " . $result['name'] . "\n";
    echo "2. Email address: " . $result['email'] . "\n";
    echo "3. Telephone number: " . $result['phone'] . "\n";
    echo "4. National ID number:" . $result['nin'] . "\n";
    echo "5. Date: " . $result['date'] . "\n";
    echo "6. Time:" . $result['time'] . " \n";
    echo "7. Go to main menu\n";
    echo "8. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            while (1) {
                $input = readline("Enter new name value:");
                $name = valName($input);
                if (!is_null($name)) {
                    editName($name, $email);
                    break;
                }
            }
            echo "Name successfully changed\n";
            break;
        case 7:
            showMainMenu();
            // require_once('main.php');
            exit();
        case 8:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showEditMenu($email);
    }
}

/* Edits name entry in the database */
function editName($name, $email)
{
    global $pdo;

    /* Edit query template */
    $query = "UPDATE users 
              SET name = :name
              WHERE (email = :email)";

    /* Values array for PDO */
    $values = [':name' => $name, ':email' => $email];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
    /* After name has been successfully changed "redirect" to showEditMenu($email) */
    echo "\033[01;32mName has been successfully changed\n \033[0m";
    showEditMenu($email);
}

/* ----- Validation functions ----- */
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
        $fullDate = $year . '-' . $regDate;

        /* Check date format */
        if (strtotime($fullDate) === FALSE) {
            echo ("\033[01;31m Error: date doesn't exist\n \033[0m");
            return NULL;
        }

        /* Get the month and day values from $fullDate input */
        $value = explode("-", $fullDate);

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
        if (strtotime($fullDate) < strtotime($today)) {
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

    /* If everythink is OK, return registration date (MM-DD) */
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
        $fullTime = $time . ':00';

        /* If appointment day is today, make sure that the user will not
           set the time in the past or out of working hours*/
        if ($appointmentDay == $today) {

            /* $opening and $closing hours */
            $opening = "08:00:00";
            $closing = "17:00:00";

            /* If the user thries to register after closing time, redirect to the main page */
            if ($fullTime > $closing) {
                echo ("\033[01;31m Sorry no appointments available for today, please register for another day\n \033[0m");
                require_once('./main.php');
                exit();
            }

            /* If the user thries to register after closing time, redirect to the main page */
            if ($timeNow < $opening) {
                echo ("\033[01;31m Error: registration hours are $opening - $closing\n \033[0m");
                return NULL;
            }

            if ($timeNow > $fullTime) {
                echo ("\033[01;31m Error: this time has already passed\n \033[0m");
                return NULL;
            }
        }

        /* Get the hour and minute values from $time input */
        $array = explode(":", $fullTime);

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

    /* If everythink is OK, return $time value in "HH:mm" format */
    return $time;
}

/* User login */
function login()
{
    /* Medical personnel email */
    $medEmail = 'med51@vaccine.com';

    /* Display menu options */
    echo "\033[0;35m User Login Page\n \033[0m";
    echo "To login, please provide your email\n";
    echo "Press X to return to main menu\n";

    $inputEmail = readline();

    if ($inputEmail === 'X') {
        showMainMenu();
    }
    /* Check if medical personnel provided correct menu
    if ($inputEmail === $medEmail) {
        showMedMenu();
    }
    */
    /* Check user's email*/
    if (valEmail($inputEmail)) {

        // Override method that checks if email exists in db

        // If all good show user settings
        showUserSettings($inputEmail);
    }
}
