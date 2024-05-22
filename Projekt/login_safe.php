<?php
    session_start();    //odprem sejo

    include("bazaPovezava.php");

    function detectSQLInjection($input) {
        // Very simple regex that checks for suspicious patterns common in SQL injections
        if (preg_match('/[\'";#--]/', $input)) {
            return true;
        }
        return false;
    }

    function detectSQLInjectionPatterns($input) {
        // Pogosti vzorci, ki se pojavljajo pri sql injectionih
        $patterns = [
            '/\b(OR|AND)\s+(1=1|0=0|TRUE|FALSE)\b/i',  // Tautologies
            '/;/',                                      // Query stacking
            '/\b(SELECT|UPDATE|DELETE|INSERT)\b/i',     // Common SQL DML commands
            '/--|\/\*/',                                // SQL comments
            '/\bUNION\b/i',                             // UNION SQL
            '/\bSLEEP\((\d*)\)\b/i',                    // Time-based injection
        ];
    
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                // javi napako
                error_log("Possible SQL Injection attempt detected: " . $input);
                return true;
            }
        }
        return false;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST["username"];
        $pass = $_POST["password"];

        //prvo preverim ali form vsebuje kakšne znake, ki so pogosto uporabljeni v sql injectionih
        if(detectSQLInjection($user) || detectSQLInjection($pass)) {
            echo json_encode(array('success' => false, 'message' => 'SQL Injection detected. Ne delaj tega!'));
            exit();
        }

        // preverim ali form vsebuje kakšne pogoste vzorce pri skq injectionih (če slučajno prva funkcija nebi nič našla)
        if (detectSQLInjectionPatterns($user) || detectSQLInjectionPatterns($pass)) {
            echo json_encode(array('success' => false, 'message' => 'Malicious input detected. Ne delaj tega!'));
            exit();
        }

        //dodam prepared statement za poizvedbo v bazi
        $stmt = mysqli_prepare($connection, "SELECT password FROM registracija WHERE username = ?");
        if($stmt === false) {
            echo json_encode(array('success' => false, 'message' => 'Database error: ' . mysqli_error($connection)));
            exit();
        }

        //vežem parametre na prepared statement
        mysqli_stmt_bind_param($stmt, "s", $user);
        //izvedem poizvedbo
        mysqli_stmt_execute($stmt);
        //vežem rezultat dobljen iz poizvedbe na novo variablo $hashedPassword
        mysqli_stmt_bind_result($stmt, $hashedPassword);

        //Fetcham rezultat
        $response = array('success' => false, 'message' => 'User not found');
        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($pass, $hashedPassword)) {
                $_SESSION['username'] = $user;
                $response = array('success' => true);
            } else {
                $response = array('success' => false, 'message' => 'Incorrect password');
            }
        }

        //zaprem prepared statement
        mysqli_stmt_close($stmt);

        // Pošljwm JSON response in prožim exit
        echo json_encode($response);
        exit();

    }

    mysqli_close($connection);  //NUJNO!!!

?>