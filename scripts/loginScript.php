<?php
    session_start();
     include_once("databaseConnection.php");
<<<<<<< HEAD
     include_once("Saltypassword.php");
     include_once("GlobalFunctions.php");
=======
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d

    $error = false;

    if( isset($_POST['btn-login']) ) {
        unset($_POST['btn-login']);

        //prevent sql injections/ clear user invalid inputs
        $email = clearString($_POST['email']);
        $pass = clearString($_POST['pass']);

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
<<<<<<< HEAD
            //$res = executeSQL("SELECT userId, userName, userPass, role FROM User WHERE userEmail='$email'");
            //$row = $res;
            //$count = count($res); // if uname/pass correct it returns must be 1 row

             //Saltyfries
            $SQL = executeSQL("SELECT userId, userName, userPass, role FROM User WHERE userEmail='$email' LIMIT 2", 1); //max 2 results
             //Get real hashed and salted password
            $Realpass = $SQL[0]["userPass"]; //Queryresult[rownumber]["collumnname"]
             //Validate the password
            $ValidPass = password_verify($password, $Realpass);

            if($ValidPass && count($SQL)){
              $_SESSION['user'] = $SQL[0]['userId'];
              $_SESSION['role'] = $SQL[0]['role'];
              print ("ingelogd!");
            }else{
              $errMSG = "Incorrect Credentials, Try again...";
              print ("niet ingelogd!");
=======
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
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d
            }
        }

    }

?>
