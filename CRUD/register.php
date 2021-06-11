<?php
require_once './functions.php';
require_once './db/db_inc.php';

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

/* Include nin number to the temporary file */
$file = 'file';
$content = json_encode($nin);
file_put_contents($file, $content);
$content = json_decode(file_get_contents($file), TRUE);

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

/* Redirect user to main menu */
echo "\033[01;32mYou have been successfully registered\n \033[0m";
require_once 'main.php';
exit();
