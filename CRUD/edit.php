<?php
require_once './functions.php';
require_once './db/db_inc.php';

$userData = getUserData($email);

$name = $userData['name'];
$email = $userData['email'];
$phone = $userData['phone'];
$nin = $userData['nin'];
$date = $userData['date'];
$time = $userData['time'];

showEditMenu($name, $email, $phone, $nin, $date, $time);

function getUserData($email): array
{
    global $pdo;

    $query = "SELECT * FROM `users`
	          WHERE (nin = :nin )";

    /* Values array for PDO */
    $values = [':nin' => $nin];

    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
        $result = $res->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Database query error');
    }
    return $result;
}

print_r(getUserData($email));

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

$userData = getUserData($nin);

showEditMenu($name, $email, $phone, $nin, $date, $time);

function editName($name)
{
    global $pdo;

    /* Edit query template */
    $query = 'UPDATE users 
              SET name = :name
              WHERE id = 1';

    /* Values array for PDO */
    $values = [':name' => $name];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}
