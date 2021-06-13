<?php

/* ----- Display functions ----- */

/* Display main menu */
function showMainMenu()
{
    echo "\033[0;35m Registration for Vaccine Form\n \033[0m";
    echo "To proceed, choose the option\n";
    echo "1. Register for appointment\n";
    echo "2. Login \n";
    echo "3. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            /* Initialise user id */
            $id = register();
            echo "\033[01;32mYou have been successfully registered\n \033[0m";
            // $id = getUserId($email);
            showUserSettings($id);
            exit();
        case 2:
            $id = login();
            echo "\033[01;32mYou have successfully logged in\n \033[0m";
            // $id = getUserId($email);
            showUserSettings($id);
            exit();
        case 3:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showMainMenu();
            exit();
    }
}

/* Function displays all appointments (for Medical Personnel)*/
function showMedMenu()
{
    echo "\033[0;35m\nRegistered Appointment Dates\n \033[0m";

    showDates();

    do {
        echo "\nTo exit type 'esc'\n";
        $input = readline("Type the date (MM-DD format) for the details ");
        $date = valDate($input);
    } while (is_null($date));

    showDetails($date);
    showMedMenu();
}


/* Display user settings options for registered or loginned users */
function showUserSettings($id)
{
    echo "\033[0;35m Welcome to User Settings Page\n \033[0m";
    echo "To proceed, choose the option\n";
    echo "1. Edit appointment\n";
    echo "2. Delete appointment\n";
    echo "3. Return the main menu\n";
    echo "4. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            showEditMenu($id);
            exit();
        case 2:
            delete($id);
            echo "Your appointment has been cancelled\n";
            showMainMenu();
            exit();
        case 3:
            showMainMenu();
            exit();
        case 4:
            exit("Application closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showUserSettings($id);
    }
}

/* Edit menu function */
function showEditMenu($id)
{
    global $pdo;

    /* Select user data from the database */
    $query = "SELECT * FROM `users`
	          WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':id' => $id];

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
    echo "7. Go to the main menu\n";
    echo "8. Exit the application\n";

    $input = readline();

    switch ($input) {
        case 1:
            while (1) {
                echo "To return type 'esc'\r";
                $input = readline("Enter new name:");
                $newName = valName($input);
                if (!is_null($newName)) {
                    editName($newName, $id);
                    echo "\033[01;32mName has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 2:
            while (1) {
                echo "To return type 'esc'\r";
                $input = readline("Enter new email:");
                $newEmail = valEmail($input);
                if (!is_null($newEmail)) {
                    editEmail($newEmail, $id);
                    echo "\033[01;32mEmail has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 3:
            while (1) {
                echo "To return type 'esc'\r";
                $input = readline("Enter new phone number:");
                $newPhone = valNumber($input);
                if (!is_null($newPhone)) {
                    editPhone($newPhone, $id);
                    echo "\033[01;32mPhone number has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 4:
            while (1) {
                echo "To return type 'esc'\r";
                $input = readline("Enter new ID number:");
                $newNin = valNumber($input);
                if (!is_null($newNin)) {
                    editNin($newNin, $id);
                    echo "\033[01;32mID number has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 5:
            while (1) {
                echo "To return type 'esc'\r";
                $input = readline("Enter new date:");
                $newDate = valDate($input);
                if (!is_null($newDate)) {
                    editDate($newDate, $id);
                    echo "\033[01;32mDate has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 6:
            while (1) {
                echo "To return type 'esc'\n";
                $input = readline("Enter new time:");
                $newTime = valTime($input);
                if (!is_null($newTime)) {
                    editTime($newTime, $id);
                    echo "\033[01;32mTime has been successfully changed\n \033[0m";
                    showEditMenu($id);
                    exit();
                }
            }

        case 7:
            showMainMenu();
            exit();
        case 8:
            exit("App closed");
        default:
            echo ("\033[01;31m Error: please enter correct value from the menu\n \033[0m");
            showEditMenu($id);
            exit();
    }
}

/* Function displays reserved appointment dates */
function showDates()
{
    global $pdo;

    /* Query template */
    $query = 'SELECT DISTINCT `date` FROM `users` WHERE 1 ORDER BY `date` ASC';

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute();
        $dates = $res->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }

    /* If array is not empty, display the dates */
    if (!empty($dates)) {
        $count = 0;
        echo "Appointment Dates:\n";
        foreach ($dates as $date) {
            echo "$date\t";
            $count++;
            if ($count % 4 === 0) {
                echo "\n";
            }
        }
    } else {
        echo "No appointments available";
    }
}

/* Function displays users data who were registered for specific date */
function showDetails($date)
{
    global $pdo;

    /* Query template */
    $query = "SELECT * FROM `users`
             WHERE `date`=:date
             ORDER BY `time` ASC";

    /* Values array for PDO */
    $values = array(':date' => $date);

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }

    echo "==================================================================================================\n";
    echo "\t\t\t\tUsers registered for $date\n";
    echo "==================================================================================================\n";
    echo "Time\t Name\t\t Phone\t\t ID number \tEmail\n";
    foreach ($data as $row) {
        echo "$row[time]\t $row[name]\t $row[phone]\t $row[nin]\t $row[email]s\n";
    }
}
