<?php
<<<<<<< HEAD
    session_start();
    include("../scripts/databaseConnection.php.php");

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
        // prevent sql injections / clear user invalid inputs

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
            print("Voor de DB zooi");
            $password = hash('sha256', $pass); // password hashing using SHA256
            $res = executeSQL ("SELECT userId, userName, userPass FROM User WHERE userEmail='$email'");
            $row = $res;
            $count = count($res); // if uname/pass correct it returns must be 1 row

            print("Na de DB zooi");
            
            if( $count == 1 && $row[0]['userPass']==$password ) {
                $_SESSION['user'] = $row['userId'];
                header("Location: index.php");
                print("AAAAAAH");
            } else {
                print("BBBBBBBBH");
                $errMSG = "Incorrect Credentials, Try again...";
            }
        }
    }
=======
  session_start();
  include("../scripts/databaseConnection.php.php");

// it will never let you open index(login) page if session is set
// if ( isset($_SESSION['user'])!="" ) {
//  header("Location: home.php");
//  exit;
// }

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
 // prevent sql injections / clear user invalid inputs

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

  $password = hash('sha256', $pass); // password hashing using SHA256
  $res = executeSQL ("SELECT userId, userName, userPass FROM User WHERE userEmail='$email'");
 // for ($i = 0; $i < count($res); ++$i){
    // print("userID " . $res["userId"]);
    //  print("userName " . $res["userName"]);
    //   print("userPass " . $res["userPass"]);
 // }
  // $row = $res;
  // $count = count($res); // if uname/pass correct it returns must be 1 row


  // if( $count == 1 && $row[0]['userPass']==$password ) {
  //  $_SESSION['user'] = $row['userId'];
  //  header("Location: index.php");
  // // print("AAAAAAH");
  // } else {
  //   //print("BBBBBBBBH");
  //  $errMSG = "Incorrect Credentials, Try again...";
  // }

 }

}
>>>>>>> 416394e7d7c821db4380bc894276fc967b8a019c
?>
