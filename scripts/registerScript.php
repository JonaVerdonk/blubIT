<?php
session_start();
include_once("databaseConnection.php");
include_once("Saltypassword.php");
include_once("GlobalFunctions.php");

$error = false;

if (isset($_POST['btn-signup']) ) {

    // clean user inputs to prevent sql injections
  $name = clearString($_POST['name']);
  $email = clearString($_POST['email']);
  $pass = clearString($_POST['pass']);
  $confirmpass = clearString($_POST['confirmpass']);

  // basic name validation
  if (empty($name)) {
    $error = TRUE;
    $errorMsg = "Please enter your full name.";
  } else if (strlen($name) < 3) {
    $error = TRUE;
    $errorMsg  = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = TRUE;
    $errorMsg  = "Name must contain alphabets and space.";
  }

  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = TRUE;
    $errorMsg  = "Please enter valid email address.";
  } else {
    // check email exist or not
    $result = executeSQL ("SELECT userEmail FROM User WHERE userEmail='$email'");
    $count = count($result);
    if($count!=0){
      $error = TRUE;
      $errorMsg  = "Provided Email is already in use.";
    }
  }
  // password validation
  if (empty($pass)){
    $error = TRUE;
    $errorMsg  = "Vul een wachtwoord in.";
  } else if(strlen($pass) < 6) {
    $error = TRUE;
    $errorMsg  = "Het wachtwoord moet uit minimaal 6 tekens bestaan.";
  } else if($pass !== $confirmpass){
    $error = TRUE;
    $errorMsg  = "De wachtwoorden komen niet overeen.";
  }

   // password encrypt using SHA256();
  $password = hash('sha256', $pass);
   //Salt the password with cost of 15(Hardware difficulty) and PASSWORD_BCRYPT
  $password = HashPass($password);

  //Error handling
  // print $passError;
  // print $nameError;
  // print $emailError;

  // if there's no error, continue to signup
  if( !$error ) {
    executeSQL ("INSERT INTO User(userName,userEmail,userPass, role) VALUES('$name','$email','$password', 'r')");
    $registered = ("Je bent succesvol geregistreerd. Log nu in om je account te gebruiken");
  }
}
  ?>
