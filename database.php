<?php

$dsn = "mysql:host=localhost; dbname= todolist";
$username = 'root';
$password = '';

try {
    $db = new PDO ($dsn, $username);
}catch (PDOException $e){
    $error_message = 'No to do list items exist yet.';
    $error_message .= $e -> getMessage();
    echo $error_message;
    exit();
}

?>