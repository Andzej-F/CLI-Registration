<?php
/*

echo ("\033[01;31m Error: \n \033[0m");


Create an application that allows users to register for vaccination.
Users should be able to provide their personal information along with
preferred date and time for the appointment. In addition medical personnel
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
• Add appointment
• Edit appointment
• Delete appointment
• Print list of appointment for specific date, sorted by time
Bonus points if you:
• Don’t use any framework
• Do validations (valid email, phone number, identification number)
• Add ability to import/export appointments in .csv format. Example of .csv file should 
be added to repositor
 */
showMainMenu();

function showMainMenu()
{
    echo "\033[0;35m Registration for Vaccine Form\n \033[0m";
    echo "To proceed, choose the option\n";
    echo "1. Register for appointment\n";
    echo "2. Login to user account\n";
    echo "3. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            require_once('login.php');
            exit();
        case 2:
            require_once('login.php');
            exit();
        case 3:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showMainMenu();
    }
}
