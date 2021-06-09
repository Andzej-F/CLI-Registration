<?php

/* Name inputs */
$inputs = [
    "John", // name
    "John Smith", // name and surname
    " John", //name begins with an empty space
    "john", // name starts with a small letter
    "NULL", // NULL as a string is valid :)
    'NULL', // NULL as a string is valid ;)
    NULL, // NULL as a string ERR
    "", // empty string string ERR
    " ", // space ERR
    " John", // space ant valid name OK
    "Lqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqqqqqqqqqqqqqqqqqqqqqqqqqqqq", // length more than 64 characters
    NULL, // NULL 
    5,
    "5",
    "John5",
    "5John",
    "5 John",
    "John 5",
    " ",
    "Jermaine O'Neal",
    "Duncan-Clyde",
    "Duncan-clyde",
    "Jerome" => "McDyess",
    " Joh",
    "  Jo",
    "  jo",
    " lee",
    " L",
    " Lee ",
    " Le",
    "Le",
    "shawn@suns.com",
    "Shawn@suns.com",
    "SHAWN@suns.com",
    "SHAWN@SUNS.com",
    "SHAWN@SUNS.Com",
    "SHAWN@SUNS.COM",
    "SHAWN@c",
    "SHAWN@com",
    "  just@com ",
    "  just@gmail.com  second@gmail.com",
    "@com",
    "12345678",
    "1234567",
    " 1234567",
    " 1234567 ",
    "  1234567 ",
    "1234567  ",
    1234567,
    '12345678',
    '1234567',
    `12345678`,
    12345678,
    00000000,
    '00000000',
    "00000000",
    "abc12345",
    "12a34a5l ",
    00012345,
    "00012345",
    "10000000",
    "01000000",
    "0100 0000",
    "1234 5678",
    "12345678 ",
    " 12345678 ",
];

foreach ($inputs as $input) {
    $result = valNumber($input);
    if (!is_null(valNumber($input))) {
        echo ("\033[0;32m Success: $input is valid\n\033[0m");
        echo ("\033[0;33m Return type of $input is $result\n\n\033[0m");
    } else {
        echo ("\033[01;31mError: input $input is not valid\n\033[0m");
        echo "\033[01;31mReturn type of $input is $result\n\033[0m";
    }
    echo "===========================================\n\n";
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
        /* Check if the ninput has numeric characters */
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
