<?php
    include("bazaPovezava.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $taskId = $_POST["taskId"];

        $query = "DELETE FROM opravilo WHERE idOpravilo = $taskId";

        if(mysqli_query($connection, $query)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'message' => 'Task deleted successfully'));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'error' => mysqli_error($connection)));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
    }

    mysqli_close($connection);
?>