<?php
require ("database.php");

$id = filter_input(INPUT_POST, "ItemNum", FILTER_VALIDATE_INT);

if ($id) {
    $query = 'DELETE FROM $todoitems 
        WHERE ID = :id';

    $statement = $db -> prepare ($query);
    $statement -> bindValue(":id", $id);
    $success = $statement -> execute();
    $statement -> closeCursor();

}

$deleted = true;

include("index.php");
?>