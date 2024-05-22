<?php
    include("bazaPovezava.php");

    $query = "SELECT naziv FROM kategorija";
    $result = mysqli_query($connection, $query);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['naziv'];
    }

    mysqli_close($connection);

    header('Content-Type: application/json');
    echo json_encode($categories);

?>