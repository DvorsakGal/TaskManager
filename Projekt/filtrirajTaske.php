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

    //FILTRIRANJE
    $categoryFilter = $_GET['category'];
    $query = "SELECT * FROM Opravilo WHERE TK_Uporabnik = $vpisaniUporabnik AND TK_Kategorija = $categoryFilter";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        mysqli_free_result($result);

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
?>