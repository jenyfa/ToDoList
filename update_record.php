<?php
require("database.php");

$id = filter_input(INPUT_POST, "ItemNuM", FILTER_VALIDATE_INT);
$Title = filter_input(INPUT_POST, "Title", FILTER_UNSAFE_RAW);
$Description = filter_input(INPUT_POST, "Description", FILTER_UNSAFE_RAW);

if ($id) {
    $query = 'UPDATE todoitems
                SET Title = :Title, Description = :Description
                WHERE ItemNum = :id
    ';

    $statement = $db -> prepare ($query);
    $statement -> bindValue (":id", $id);
    $statement -> bindValue (":Title", $Title);
    $statement -> bindValue (":Description", $Description);
    $success = $statement -> execute();
    $statement -> closeCursor();

}

$updated = true;

include("index.php");
?>

