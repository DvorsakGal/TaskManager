<?php
    session_start();    //odprem sejo

    include("bazaPovezava.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $opravilo = $_POST["task"];
        $opomba = $_POST["notes"];
        $kategorija = $_POST["category"];
        $cas = $_POST["time"];
    }

    $uporabnik = $_SESSION["username"];
    $vpisaniUporabnik = "";
    $query = "SELECT idRegistracija FROM registracija WHERE username = '$uporabnik'";
    $result = mysqli_query($connection, $query);

    if($result) {
        $row = mysqli_fetch_assoc($result);
        if($row) {
            $vpisaniUporabnik = $row["idRegistracija"];
        }
    }

    $idKategorije = "";
    $query2 = "SELECT idKategorija FROM kategorija WHERE naziv = '$kategorija'";
    $result2 = mysqli_query($connection, $query2);

    if($result2) {
        $row = mysqli_fetch_assoc($result2);
        if($row) {
            $idKategorije = $row["idKategorija"];
        }
    }

    $idCasa = "";
    $query3 = "SELECT idCas FROM cas WHERE timeAttribute = '$cas'";
    $result3 = mysqli_query($connection, $query3);

    if($result3) {
        $row = mysqli_fetch_assoc($result3);
        if($row) {
            $idCasa = $row["idCas"];
        }
    }

    if($vpisaniUporabnik !== "" && $idKategorije !== "" && $idCasa !== "") {
        $sql = "INSERT INTO opravilo (naslov, opis, TK_Kategorija, TK_Cas, TK_Uporabnik) VALUES ('{$opravilo}', '{$opomba}', {$idKategorije}, {$idCasa}, {$vpisaniUporabnik})";
        mysqli_query($connection, $sql);
        echo"dodal si " . $opravilo . "   " . $opomba . "   " . $idKategorije . "   " . $idCasa . "   " . $vpisaniUporabnik;
    } else {
        echo "Uporabnik ali kategorija ali cas ne obstaja";
    }
    
    
    mysqli_close($connection);  //NUJNO!!!
?>