<?php
    include("bazaPovezava.php");

    $kategorija = strtoupper("");

    $sql = "INSERT INTO kategorija (naziv) VALUES ('$kategorija')";
    
    //to bi blo pametno dat v try-catch blok
    mysqli_query($connection, $sql);
    echo"dodal si " . $kategorija;
    mysqli_close($connection);  //NUJNO!!!
?>