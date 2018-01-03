<?php
    session_start();
     include_once("databaseConnection.php");
     include_once("Saltypassword.php");
     include_once("GlobalFunctions.php");

    $errorLogin = false;

    //Wanneer de button Login is ingedrukt wordt de volgende code uitgevoerd.
    if( isset($_POST['btn-login']) ) {
        unset($_POST['btn-login']);

        //Gaat SQL injectie tegen
        $email = clearString($_POST['email']);
        $pass = clearString($_POST['pass']);

        //Tegen SQL injectie + wanneer password leeg/ongeldig is error.
        if(empty($email)){
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. uw emailadres in. ";
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. een geldig emailadres in. ";
        }

        //Checkt of het wachtwoord niet leeg is.
        if(empty($pass)){
            $errorLogin = true;
            $errorLoginMsg = "Voer a.u.b. een wachtwoord in. ";
        }

            //Als er geen error is, verder naar login
            if (!$errorLogin) {

                //Password wordt gehast met SHA256
                $password = hash('sha256', $pass);

                 //Saltyfries
                $SQL = executeSQL("SELECT userId, userName, userPass, role, blocked FROM User WHERE userEmail='$email' LIMIT 2", 1); //max 2 results
                 //Get real hashed and salted password
                $Realpass = $SQL[0]["userPass"]; //Queryresult[rownumber]["collumnname"]
                 //Validate the password
                $ValidPass = password_verify($password, $Realpass);
                /*print ("blocked: " . $SQL[0]["blocked"] . " einde blocked");*/

                //Wanneer er geen foutmeldingen zijn wordt de user ingelogd.
                if($ValidPass && count($SQL) && $SQL[0]["blocked"] == 0){
                  executeSQL("UPDATE User SET lastLogin=NOW() WHERE userEmail='$email'");
                  $_SESSION['user'] = $SQL[0]['userId'];
                  $_SESSION['role'] = $SQL[0]['role'];
                  $_SESSION['logged_in'] = 1;
                  $_SESSION['username'] = $SQL[0]['userName'];
                  $login = ("Je bent succesvol ingelogd.");

            }else{
                //Bij fouteive inlog wordt dit geregistreerd. Bij 3 fouteive inloggen wordt de user voor 15 minuten geblockt.
                $attempts = executeSQL("SELECT attempts,blocked FROM User WHERE userEmail='$email'", 1);
                if($attempts[0]["attempts"] == 3){
                    executeSQL("UPDATE User SET attempts= 0, blocked= 1, lastLogin=NOW() WHERE userEmail='$email'", 1);
                    $errorLogin = true;
                    $errorLoginMsg = "U heeft 3 keer uw inloggegevens incorrect ingevuld uw account is tijdelijk geblokkeerd probeert u het a.u.b. over 15 minuten opnieuw";
                }elseif($attempts[0]['blocked'] == 1){
                    $now = date("Y-m-d H:i:s");
                    $lastLoginAttempt = executeSQL("SELECT lastLogin FROM User WHERE userEmail='$email'", 1);
                    $time_difference = strtotime($now) - strtotime($lastLoginAttempt);
                    /*print ("na timediffference " . $time_difference);*/
                    if($time_difference >= 900){
                        executeSQL("UPDATE User SET blocked = 0, lastLogin=NOW() WHERE userEmail='$email'", 1);
                    }else{
                        /*print "in else voor errormessages ";*/
                        $errorLogin = true;
                        $errorLoginMsg = "Uw account is tijdelijk geblokkeerd probeer het straks opnieuw";
                    }
                }else {
                    $oldAttempts = executeSQL("SELECT attempts FROM User WHERE userEmail='$email'", 1);
                    $newAttempts = ($oldAttempts[0]['attempts'] + 1);
                    executeSQL("UPDATE User SET attempts='$newAttempts', lastLogin=NOW() WHERE userEmail='$email'", 1);
                    $errorLogin = true;
                    $errorLoginMsg = "Inloggegevens zijn incorrect. Probeert u het a.u.b. opnieuw. Indien u uw email en/of wachtwoord bent vergeten, kunt u via het contactformulier uw gegevens opvragen. ";

                }


           }
        }

    }

?>
