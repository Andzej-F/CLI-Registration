#!/usr/bin/php
<?php
// /*
// $file = fopen('users.csv', 'r');
// $getData = fgetcsv($file);
// print_r($getData);
//  print_r(get_defined_vars());
// fclose($file);
// */



// /*
// Amare,
// amare@suns.com
// "Steve Nash",
// steve@suns.com
//  */

// /* 1. Read from file 'users.csv' */
// /* 1. Read the last line from file 'users.csv' */

// $filename = 'users.csv';
// $data = [];

// $f = fopen($filename, 'r');

// while ($row = fgetcsv($f)) {
//     $data[] = $row;
// }

// // print_r($data);

// // foreach ($data as $userInfo) {
// //     echo $id = $userInfo[0] . "\n";
// //     echo $name = $userInfo[1] . "\n";
// //     echo $email = $userInfo[2] . "\n\n";
// // }

// /* 2. Get the latest user id value */
// echo " Id of the latest user is $id\n";

// if (!$f) {
//     fclose($f);
// }

// /* 3. Register a new user */
// $file = fopen('users.csv', 'a');
// $name = readline("Enter your name: ");
// $email = readline("Enter your email: ");
// $data = [1, $name, $email];
// fputcsv($file, $data);
// fclose($file);
// $argv[] = 15;
// $_SESSION['au'] = 15;
// print_r($argv);
// $name = readline("Enter your name: ");
// $argv[] = $name;
// print_r($argv);

// $options = getopt("abc");
// var_dump($options);

// Lit 3 commandes de l'utilisateur
// for ($i = 0; $i < 3; $i++) {
//     $line = readline("Commande : ");
//     readline_add_history($line);
// }

// // Liste l'historique
// print_r(readline_list_history());

// // Liste les variables
// print_r(readline_info());

// require_once 'globals.php';
// echo Globals::$car;

// $argv[] = 25;
// var_dump($argv);

echo file_get_contents('main.php');
