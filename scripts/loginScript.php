<?php
    session_start();
     include_once("databaseConnection.php");
     include_once("Saltypassword.php");
     include_once("GlobalFunctions.php");

    $errorLogin = false;

    if( isset($_POST['btn-login']) ) {
        unset($_POST['btn-login']);

        //prevent sql injections/ clear user invalid inputs
        $email = clearString($_POST['email']);
        $pass = clearString($_POST['pass']);

        // prevent sql injections / clear user  invalid inputs

        if(empty($email)){
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. uw emailadres in. ";
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. een geldig emailadres in. ";
        }

        if(empty($pass)){
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. een wachtwoord in. ";
        }

        // if there's no error, continue to login
        if (!$errorLogin) {
            //testFunction();
            $password = hash('sha256', $pass); // password hashing using SHA256
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
              $_SESSION['logged_in'] = 1;
              $_SESSION['username'] = $SQL[0]['userName'];
              $login = ("Je bent succesvol ingelogd.");

            }else{
              $errorLogin = true;
              $errorLoginMsg = "Inloggegevens zijn incorrect. Probeert u het a.u.b. opnieuw. Indien u uw email en/of wachtwoord bent vergeten, kunt u via het contactformulier uw gegevens opvragen. ";
           }
        }

    }

?>
