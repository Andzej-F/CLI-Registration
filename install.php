<?php

/* Create new database `registration`and table `users` */

/* Host name of the MySQL server */
$host = 'localhost';

/* MySQL account username */
$user = 'root';

/* MySQL account password */
$passwd = '';

/* The PDO object */
$pdo = NULL;

/* Connection string, or "data source name" */
$dsn = 'mysql:host=' . $host;

/* Connection inside a try/catch block */
try {
    /* PDO object creation */
    $pdo = new PDO($dsn, $user,  $passwd);

    $query = file_get_contents("db/init.sql");
    echo '<pre>';
    print_r($query);
    $pdo->exec($query);
    echo "\nDatabase 'registration' and table 'users' created successfully\n";

    /* Enable exceptions on errors */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    /* If there is an error an exception is thrown */
    echo 'Database connection failed<br>';
    die();
}
