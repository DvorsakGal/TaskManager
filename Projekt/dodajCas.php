<?php
    include("bazaPovezava.php");

    $time = strtoupper("yearly");

    $sql = "INSERT INTO cas (timeAttribute) VALUES ('$time')";
    
    //to bi blo pametno dat v try-catch blok
    mysqli_query($connection, $sql);
    echo"dodal si " . $time;
    mysqli_close($connection);  //NUJNO!!!
?>