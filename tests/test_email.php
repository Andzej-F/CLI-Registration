<?php

/* Name inputs */
$inputs = [
    // "John", // name
    // "John Smith", // name and surname
    // " John", //name begins with an empty space
    // "john", // name starts with a small letter
    // "NULL", // NULL as a string is valid :)
    // 'NULL', // NULL as a string is valid ;)
    // NULL, // NULL as a string ERR
    // "", // empty string string ERR
    // " ", // space ERR
    // " John", // space ant valid name OK
    // "Lqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqqqqqqqqqqqqqqqqqqqqqqqqqqqq", // length more than 64 characters
    // NULL, // NULL 
    // 5,
    // "5",
    // "John5",
    // "5John",
    // "5 John",
    // "John 5",
    // " ",
    // "Jermaine O'Neal",
    // "Duncan-Clyde",
    // "Duncan-clyde",
    // "Jerome" => "McDyess",
    // " Joh",
    // "  Jo",
    // "  jo",
    // " lee",
    // " L",
    // " Lee ",
    // " Le",
    // "Le",
    // "shawn@suns.com",
    // "Shawn@suns.com",
    // "SHAWN@suns.com",
    // "SHAWN@SUNS.com",
    // "SHAWN@SUNS.Com",
    // "SHAWN@SUNS.COM",
    // "SHAWN@c",
    // "SHAWN@com",
    //"  just@com ",
    // "  just@gmail.com  second@gmail.com",
    //"@com",
];

foreach ($inputs as $input) {
    $result = valEmail($input);
    if (!is_null(valEmail($input))) {
        echo ("\033[0;32m Success: $input is valid\n\033[0m");
        echo ("\033[0;33m Return type of $input is $result\n\n\033[0m");
    } else {
        echo ("\033[01;31mError: input $input is not valid\n\033[0m");
        echo "\033[01;31mReturn type of $input is $result\n\033[0m";
    }
    echo "===========================================\n\n";
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

    /* If everythink is OK, return $email value */
    return $email;
}
