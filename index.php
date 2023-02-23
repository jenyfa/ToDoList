<?php
//POST Data
$Title = filter_input(INPUT_POST, "Title", FILTER_UNSAFE_RAW);
$Description = filter_input(INPUT_POST, "Description", FILTER_UNSAFE_RAW);

//GET Data
$todoitems = filter_input(INPUT_GET, "To Do Item", FILTER_UNSAFE_RAW);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
</head>
<body>
    <main>
        <header>
            <h1>To Do List</h1>
        </header>
        <?php

            if(!$Title) { ?>
                <section>
                    <h2>Select Title/ Read To Do list</h2>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "GET">
                    <label for="Title"> Title: </label>
                    <input type="text" id= "Title" name = "Title" required>
                    <button>Submit</button>
                    
                    </form>

                </section>

                <section>
                    <h2>Insert/ Create Data</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
                    <label for="Description"> Description: </label>
                    <input type="text" id= "Description" name = "Description" required>
                    <button>Submit</button>
                    </form>
                </section>

            <?php    

            }else {
                ?>

                    <?php
                        include("/database.php")?>

                    <?php
                    if($Title){
                        $query = ' INSERT INTO todoitems
                                    (Title, Description)
                                    VALUES (:Title, :Description)
                        ';
                        $statement = $db->{$query};
                        $statement ->bindValue (':Title', $Title);
                        $statement ->bindValue (':Description', $Description);
                    }
                    ?>

                    <?php
                        if ($Title || $Description) {
                            $query = 'SELECT * FROM todoitems
                                        WHERE Title = :Title
                                            ORDER BY ItemNum Desc ';
                            $statement = $db -> prepare($query);
                            if ($todoitems) {
                                $statement ->bindValue(":Title", $todoitems);
                            } else {
                                $statement -> bindValue(":Title", $Title);
                            }

                            $statement -> execute();
                            $results = $statement -> fetchAll();
                            $statement->closeCursor();
                        }
                    ?>
                    <?php 
                    if (!empty($results)) { ?>
                        <section>
                            <h2>Update or Delete Data</h2>
                        </section>

                            <?php foreach ($results as $result){
                                $id = $result["ItemNum"];
                                $Title = $result["Title"];
                                $Description = $result["Description"];

                            ?>

                            <form action="update_record.php" method= "POST">
                                <input type="hidden" name = "id" value= "<?php echo $id ?>">

                                <label for="Title <?php echo $Title ?>"> Title: </label>
                                <input type="text" name = "Title" value = "<?php echo $Title ?>">

                                <label for="Description <?php echo $Description ?>"> Description: </label>
                                <input type="text" name = "Description" value = "<?php echo $Description ?>">

                                <button> Update</button>
                            </form>

                            <form action="delete_record.php" method = "POST">
                            <input type="hidden" name ="id" value= "<?php echo $id ?>">

                            <button>Delete</button>
                            </form>

                        <?php } ?>
                                
                    <?php}else { ?>
                    <p>Sorry, no results!</p> <?php} ?>

                    <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Go to request form</a>

                <?php } ?>


    </main>
</body>
</html>