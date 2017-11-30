<?php
  session_start();
  include("../scripts/databaseConnection.php.php");

$error = false;


 if ( isset($_POST['btn-signup']) ) {

  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name must contain alphabets and space.";
  }

  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $result = executeSQL ("SELECT userEmail FROM User WHERE userEmail='$email'");
   $count = count($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Vul een wachtwoord in.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Het wachtwoord moet uit minimaal 6 tekens bestaan.";
 } else if($pass !== $confirmpass){
   $error = true;
   $passError = "De wachtwoorden komen niet overeen.";
 }

  // password encrypt using SHA256();
  $password = hash('sha256', $pass);

  // if there's no error, continue to signup
  if( !$error ) {

   executeSQL ("INSERT INTO User(userName,userEmail,userPass) VALUES('$name','$email','$password')");
  }
 }
?>
