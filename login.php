<?php

require_once './functions.php';
require_once './db/db_inc.php';

echo "\033[0;35m Login Page\n \033[0m";
echo "To exit the application press X\n";
echo "To login please enter your email: X\n";

do {
    $input = readline("Email:");
    $email = valEmail($input);
} while (!userExist($email));

/* If user exists, show login menu*/

showLoginMenu();


/* Checks if the user has already been registered */
function userExist($email) //:bool
{
    // return true or false
    //return $userData;
}

$userData = getUserData($email);

$name = $userData['name'];
$email = $userData['email'];
$phone = $userData['phone'];
$nin = $userData['nin'];
$date = $userData['date'];
$time = $userData['time'];


function showLoginMenu()
{
    echo "To proceed, choose the enter your email\n";
    echo "1. Edit appointment\n";
    echo "2. Delete appointment\n";
    echo "3. Go to main menu\n";
    echo "4. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            showEditMenu($name, $email, $phone, $nin, $date, $time);
            break;
        case 3:
            require_once('main.php');
            exit();
        case 4:
            exit("Application closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showLoginMenu();
    }
}

function showEditMenu($name, $email, $phone, $nin, $date, $time)
{
    echo "\033[0;35m Choose the data fields you would like to edit\n \033[0m";
    echo "1. Name: $name \n";
    echo "2. Email address: $email \n";
    echo "3. Telephone number: $phone \n";
    echo "4. National ID number: $nin \n";
    echo "5. Date: $date \n";
    echo "6. Time: $time \n";
    echo "7. Go to main menu\n";
    echo "8. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            while (1) {
                $input = readline("Enter new name value:");
                $name = valName($input);
                if (!is_null($name)) {
                    editName($name);
                    break;
                }
            }
            echo "Name successfully changed\n";
            break;
        case 7:
            require_once('main.php');
            exit();
        case 8:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showEditMenu($name, $email, $phone, $nin, $date, $time);
    }
}
