<?php
    include("bazaPovezava.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST,"txt", FILTER_SANITIZE_SPECIAL_CHARS);
        $mail = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO registracija (username, email, password) VALUES ('{$username}', '{$mail}', '{$hash}')";
    
    //to bi blo pametno dat v try-catch blok
    mysqli_query($connection, $sql);
    echo"DONE";
    mysqli_close($connection);  //NUJNO!!!
?>
