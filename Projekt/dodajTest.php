<?php
    include("bazaPovezava.php");

    $test = strtoupper("mama");

    $sql = "INSERT INTO test (naziv) VALUES ('$test')";
    
    //to bi blo pametno dat v try-catch blok
    mysqli_query($connection, $sql);
    echo"dodal si " . $test;
    mysqli_close($connection);  //NUJNO!!!
?>