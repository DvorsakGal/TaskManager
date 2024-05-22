<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // Redirect to the login page if not logged in
        header("Location: public/login.html");
        exit();
    }
    include("bazaPovezava.php");

    $uporabnik = $_SESSION["username"];
    $vpisaniUporabnik = "";
    $user_query = "SELECT idRegistracija FROM registracija WHERE username = '$uporabnik'";
    $user_result = mysqli_query($connection, $user_query);

    if($user_result) {
        $row = mysqli_fetch_assoc($user_result);
        if($row) {
            $vpisaniUporabnik = $row["idRegistracija"];
        }
    }



    $query = "SELECT * FROM Opravilo WHERE TK_Uporabnik = $vpisaniUporabnik";
    $result = mysqli_query($connection, $query);

    if($result) {
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        mysqli_free_result($result);

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
/*
    if($result) {
        while($task = mysqli_fetch_assoc($result)) {
            echo "Task id: " . $task['idOpravilo'] . "<br>";
            echo "naslov: " . $task['naslov'] . "<br>";
            echo "opiis: " . $task['opis'] . "<br>";
            echo "opravljeno: " . $task['opravljeno'] . "<br>";
            echo "kategorija: " . $task['TK_Kategorija'] . "<br>";
            echo "cas: " . $task['TK_Cas'] . "<br>";
            echo "TK_Uporabnik: " . $task['TK_Uporabnik'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "Error retrieving tasks: " . mysqli_error($connection);
    }
*/
    mysqli_close($connection);

?>