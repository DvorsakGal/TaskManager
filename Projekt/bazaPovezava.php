<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "taskmanager";
    $port = "3307";
    $connection = "";

    try {
        $connection = mysqli_connect($db_server, $db_user, $db_password, $db_name, $port);
    }
    catch(mysqli_sql_exception) {
        echo "could not connect";
    }
?>