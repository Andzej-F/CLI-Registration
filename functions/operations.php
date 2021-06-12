<?php

/* Add user data to the system (register for appointment), return newly registered user id value */
function register(): int
{
    echo "\033[0;35m Registration Page\n \033[0m";
    echo "To escape type 'esc'\n";
    echo "Please enter the following information about you:\n";

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
            $time = valTime($input);
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
    /* Return registered user id*/
    return $pdo->lastInsertId();
}


/* Function return logged in user id */
function login()
{
    /* Medical personnel email */
    $medEmail = 'med@med.com';

    /* Display menu options */
    echo "\033[0;35m User Login Page\n \033[0m";
    echo "Type 'esc' to return to main menu\n";
    echo "To login, please provide your email: \n";

    $input = readline();

    if ($input === 'esc') {
        showMainMenu();
    }

    /* Medical personel login */
    if ($input == $medEmail) {
        $email = valEmail($input);
        if (!is_null($email)) {
            showMedMenu();
            exit();
        }
    }

    /* Check user's email*/
    $email = valEmail($input);
    if (!is_null($email)) {

        // TODO Override method that checks if email exists in db

        /* Global $pdo object */
        global $pdo;

        /* Query template */
        $query = 'SELECT id FROM users
                    WHERE (email = :email)';

        /* Values array for PDO */
        $values = array(':email' => $email);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
            $result = $res->fetch(PDO::FETCH_ASSOC);
            $id = $result['id'];
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
        // If all good return user id
        return intval($id, 10);
    } else {
        login();
    }
}

/* Deletes user data selected by id */
function delete($id)
{
    /* Global $pdo object */
    global $pdo;

    /* Query template */
    $query = 'DELETE FROM users
              WHERE (id = :id)';

    /* Values array for PDO */
    $values = array(':id' => $id);

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}
