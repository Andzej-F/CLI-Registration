<?php

/* Name inputs */
$inputs = [
    //"John", // name
    //"John Smith", // name and surname
    //" John", //name begins with an empty space
    //"john", // name starts with a small letter
    // "NULL", // NULL as a string is valid :)
    // 'NULL', // NULL as a string is valid ;)
    //NULL, // NULL as a string ERR
    //"", // empty string string ERR
    // " ", // space ERR
    // " John", // space ant valid name OK
    //"Lqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqqqqqqqqqqqqqqqqqqqqqqqqqqqq", // length more than 64 characters
    //NULL, // NULL 
    // 5,
    //"5",
    // "John5",
    // "5John",
    // "5 John",
    // "John 5",
    // " ",
    // "Jermaine O'Neal",
    // "Duncan-Clyde",
    // "Duncan-clyde",
    // "Jerome" => "McDyess",
    // "X",
    // " X",
    // "  X",
    // "  x",
    // "x",
    // " Joh",
    // "  Jo",
    // "  jo",
    // " lee",
    // " L",
    // " Lee ",
    // " Le",
    // "Le",
];

foreach ($inputs as $input) {
    if (!is_null(valName($input))) {
        $result = valName($input);
        echo ("\033[0;32m Success: $input is valid\n\033[0m");
        echo ("\033[0;33m Return type of $input is $result\n\n\033[0m");
    } else {
        //echo ("\033[01;31mError: input $input is not valid\n\033[0m");
        // echo "\033[01;31mReturn type of $input is $result\n\033[0m";
    }
    echo "===========================================\n\n";
}


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
