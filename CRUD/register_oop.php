<?php

require_once './functions.php';
require_once './db/db_inc.php';
require_once './User.php';

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

/* Create user's object */
$user = new User($name, $email, $phone, $nin, $date, $time);

/* After successful validation write user's data to the database */

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
//TODO delete when n-needed
print_r(get_defined_vars());
try {
    $res = $pdo->prepare($query);
    $res->execute($values);
} catch (PDOException $e) {
    /* If there is a PDO exception, throw a standard exception */
    throw new Exception("\033[01;31m Error: Database query error\n \033[0m");
}

/* Redirect user to "user settings" */
echo "\033[01;32mYou have been successfully registered\n \033[0m";
require_once 'user_settings.php';
exit();
