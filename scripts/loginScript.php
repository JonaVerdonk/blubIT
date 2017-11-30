<?php
    session_start();
     include_once("databaseConnection.php");

    $error = false;

    if( isset($_POST['btn-login']) ) {
        unset($_POST['btn-login']);

        //prevent sql injections/ clear user invalid inputs
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);

        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
        // prevent sql injections / clear user  invalid inputs

        if(empty($email)){
            $error = true;
            $emailError = "Please enter your email address.";
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $emailError = "Please enter valid email address.";
        }

        if(empty($pass)){
            $error = true;
            $passError = "Please enter your password.";
        }

        // if there's no error, continue to login
        if (!$error) {
            //testFunction();
            $password = hash('sha256', $pass); // password hashing using SHA256
            $res = executeSQL("SELECT userId, userName, userPass, role FROM User WHERE userEmail='$email'");
            $row = $res;
            $count = count($res); // if uname/pass correct it returns must be 1 row


            if( $count == 1 && $row[0]['userPass']==$password ) {
                $_SESSION['user'] = $row[0]['userId'];
                $_SESSION['role'] = $row[0]['role'];
                print ("ingelogd!");
                //header("Location: /index.php");


            } else {
                $errMSG = "Incorrect Credentials, Try again...";
                print ("niet ingelogd!");
            }
        }

    }

?>
