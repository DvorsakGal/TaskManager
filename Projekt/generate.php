<?php

    require("fpdf186/fpdf.php");

    $pdf = new FPDF();

    if(isset($_POST['create'])) {

        $date = $_POST['date'];
        $taskcount = $_POST['taskcount'];
        $porocilo = $_POST['porocilo'];

        $pdf -> AddPage();
        $pdf->SetFont('Times');

        $pdf -> Cell(50, 10, "Date", 1, 0);
        $pdf -> Cell(140, 10, $date, 1, 1);

        $pdf -> Cell(50, 10, "Task count", 1, 0);
        $pdf -> Cell(140, 10, $taskcount, 1, 1);

        $pdf -> Cell(50, 100, "Porocilo", 1, 0);
        $pdf -> Cell(140, 100, $porocilo, 1, 1);

        $pdf -> Output();
    }

?>