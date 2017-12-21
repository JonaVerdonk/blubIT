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
    $errorMsg = "Voer a.u.b. uw volledige naam in. ";
  } else if (strlen($name) < 3) {
    $error = TRUE;
    $errorMsg  = "Uw volledige naam moet tenminste 3 tekens hebben.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = TRUE;
    $errorMsg  = "Uw volledige naam moet letters en een spatie bevatten.";
  }

  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = TRUE;
    $errorMsg  = "Voer a.u.b. een geldig emailadres in. ";
  } else {
    // check email exist or not
    $result = executeSQL ("SELECT userEmail FROM User WHERE userEmail='$email'");
    $count = count($result);
    if($count!=0){
      $error = TRUE;
      $errorMsg  = "Dit emailadres is al in gebruik. Log in met uw bestaande account. Indien u uw wachtwoord vergeten bent kunt u via het contactformulier bij de beheerder een nieuw wachtwoord aanvragen. ";
    }
  }
  // password validation
  if (empty($pass)){
    $error = TRUE;
    $errorMsg  = "Vul een wachtwoord in.";
  } else if(strlen($pass) < 8) {
    $error = TRUE;
    $errorMsg  = "Het wachtwoord moet uit minimaal 8 tekens bestaan.";
  } else if(!preg_match('/[0-9]/', $pass)){
    $error = TRUE;
    $erroMsg = "Het wachtwoord moet mininmaal 1 cijfer bevatten";
  } else if(!preg_match('/[a-z]/', $pass)){
    $error = TRUE;
    $errorMsg = "Het wachtwoord moet minimaal 1 kleine letter bevatten";
  } else if(!preg_match('/[A-Z]/', $pass)){
    $error = TRUE;
    $errorMsg = "Het wachtwoord moet minimaal 1 hoofdletter bevatten";
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
    executeSQL ("INSERT INTO User(userName,userEmail,userPass, role, attempts) VALUES('$name','$email','$password', 'r', '0')");
    $registered = ("Je bent succesvol geregistreerd. Log nu in om je account te gebruiken");
  }
}
  ?>
