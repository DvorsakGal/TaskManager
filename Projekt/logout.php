<?php
    session_start();

    //počisti shranjene vrednosti v $_SESSION variabli
    $_SESSION = array();

    //unici session
    session_destroy();

    header("Location: public/login.html");
    exit();
?>