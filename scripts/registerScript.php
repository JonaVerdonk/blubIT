<?php
session_start();
include_once("databaseConnection.php");
include_once("Saltypassword.php");
include_once("GlobalFunctions.php");

$error = false;

if (isset($_POST['btn-signup']) ) {

    // Tegen SQL injectie.
  $name = clearString($_POST['name']);
  $email = clearString($_POST['email']);
  $pass = clearString($_POST['pass']);
  $confirmpass = clearString($_POST['confirmpass']);

  // Basis naam validatie.
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

  //Basis email verificatie
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = TRUE;
    $errorMsg  = "Voer a.u.b. een geldig emailadres in. ";
  } else {
    // Controleer of het email adres al bestaat in de database.
    $result = executeSQL ("SELECT userEmail FROM User WHERE userEmail='$email'");
    $count = count($result);
    if($count!=0){
      $error = TRUE;
      $errorMsg  = "Dit emailadres is al in gebruik. Log in met uw bestaande account. Indien u uw wachtwoord vergeten bent kunt u via het contactformulier bij de beheerder een nieuw wachtwoord aanvragen. ";
    }
  }
  // Password validatie. Password moet aan verschillende eisen worden voldaan.
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

   // Password wordt geencrypt met SHA256.
  $password = hash('sha256', $pass);
   //Password wordt gesalt. Cost is 10.
  $password = HashPass($password);

  // Wanneer er geen error is, gaan de registratie verder.
  if( !$error ) {
    executeSQL ("INSERT INTO User(userName,userEmail,userPass, role, attempts) VALUES('$name','$email','$password', 'r', '0')");
    $registered = ("Je bent succesvol geregistreerd. Log nu in om je account te gebruiken");
  }
}
  ?>
