<?php
    session_start();    //odprem sejo

    include("bazaPovezava.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST["username"];
        $pass = $_POST["password"];

        $query = "SELECT password FROM registracija WHERE username = '$user'";
        //$result = mysqli_query($connection, $query);

        //TUKAJ SEM DOVOLIL MULTIPLE QUERIES IN TAKOJE BILO MOŽNO ZBRISATI TABELO
        if (mysqli_multi_query($connection, $query)) {
            do {
                // Handle the result of the query
                if ($result = mysqli_store_result($connection)) {
                    mysqli_free_result($result);
                }
                // Prepare next result set
            } while (mysqli_next_result($connection));
        } else {
            echo "Query error: " . mysqli_error($connection);
        }
        

        if($result) {
            $row = mysqli_fetch_assoc($result);
            if($row) {
                $hashedPassword = $row["password"];
                if(password_verify($pass, $hashedPassword)) {
                    $_SESSION['username'] = $user;  //user se shrani v session global variable
                    echo json_encode(array('success' => true)); //poslji JSON na frontend
                    exit(); //koda za exit() komando se ne bo izvedla
                } else {
                    // napacno geslo
                    echo json_encode(array('success' => false, 'message' => 'Incorrect password'));
                    exit();
                }
            } else {
                // napacen username
                echo json_encode(array('success' => false, 'message' => 'User not found'));
                exit();
            }
        } else {
            // database error
            echo json_encode(array('success' => false, 'message' => 'Database error: ' . mysqli_error($connection)));
            exit();
        }

    }

    mysqli_close($connection);  //NUJNO!!!

?>