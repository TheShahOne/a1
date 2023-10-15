<?php
    //define db variable
    $dbFile = 'databases/music.db'; 

    try {
        //create PDO database connection
        $pdo = new PDO("sqlite:$dbFile");
        //throw exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        //handle exception
        die('failed connection' . $e->getMessage());
    }
?>


