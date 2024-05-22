<?php
    include("bazaPovezava.php");

    $sql = "INSERT INTO registracija (username, email, password) VALUES ('krajnc', 'miha.tirs@mail.com', 'geslo2')";
    
    //to bi blo pametno dat v try-catch blok
    mysqli_query($connection, $sql);

    mysqli_close($connection);  //NUJNO!!!
?>