<?php
    include("bazaPovezava.php");

    $query = "SELECT timeAttribute FROM cas";
    $result = mysqli_query($connection, $query);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['timeAttribute'];
    }

    mysqli_close($connection);

    header('Content-Type: application/json');
    echo json_encode($categories);

?>