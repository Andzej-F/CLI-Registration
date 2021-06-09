<?php
showUserSettings();

function showUserSettings()
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
            require_once('edit.php');
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
            showUserSettings();
    }
}
