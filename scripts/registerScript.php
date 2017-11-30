<?php
session_start();
include_once("databaseConnection.php");
<<<<<<< HEAD
include_once("Saltypassword.php");
include_once("GlobalFunctions.php");
=======
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d

$error = false;
print "blub1000";

if (isset($_POST['btn-signup']) ) {

<<<<<<< HEAD
    // clean user inputs to prevent sql injections
  $name = clearString($_POST['name']);
  $email = clearString($_POST['email']);
  $pass = clearString($_POST['pass']);
  $confirmpass = clearString($_POST['confirmpass']);
  
  // basic name validation
  if (empty($name)) {
    $error = TRUE;
    $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
    $error = TRUE;
    $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = TRUE;
=======
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  print "blub2";
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  print "blub3";
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  print "blub4";
  $confirmpass = trim($_POST['confirmpass']);
  $confirmpass = strip_tags($confirmpass);
  $confirmpass = htmlspecialchars($confirmpass);
  // basic name validation
  if (empty($name)) {
    $error = true;
    $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
    $error = true;
    $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = true;
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d
    $nameError = "Name must contain alphabets and space.";
  }
  print "blub5";
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
<<<<<<< HEAD
    $error = TRUE;
=======
    $error = true;
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d
    $emailError = "Please enter valid email address.";
  } else {
    // check email exist or not
    $result = executeSQL ("SELECT userEmail FROM User WHERE userEmail='$email'");
    $count = count($result);
    if($count!=0){
<<<<<<< HEAD
      $error = TRUE;
      $emailError = "Provided Email is already in use.";
    }
  }
  // password validation
  if (empty($pass)){
    $error = TRUE;
    $passError = "Vul een wachtwoord in.";
  } else if(strlen($pass) < 6) {
    $error = TRUE;
    $passError = "Het wachtwoord moet uit minimaal 6 tekens bestaan.";
  } else if($pass !== $confirmpass){
    $error = TRUE;
    $passError = "De wachtwoorden komen niet overeen.";
  }
=======
      $error = true;
      $emailError = "Provided Email is already in use.";
    }   print "blub5";
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
  }  print "blub6";
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d

   // password encrypt using SHA256();
  $password = hash('sha256', $pass);
<<<<<<< HEAD
   //Salt the password with cost of 15(Hardware difficulty) and PASSWORD_BCRYPT
  $password = HashPass($password);

  //Error handling
  print $passError;
  print $nameError;
  print $emailError;

  // if there's no error, continue to signup
  if( !$error ) {
    executeSQL ("INSERT INTO User(userName,userEmail,userPass, role) VALUES('$name','$email','$password', 'r')");
  }
}
=======
  print "blub7";
  print $passError;
  print $nameError;
  // if there's no error, continue to signup
  if( !$error ) {
    print "blub8";
    executeSQL ("INSERT INTO User(userName,userEmail,userPass, role) VALUES('$name','$email','$password', 'r')");
    print "blub9";}
  }
>>>>>>> 02697470309f2af0058edd5f4e11d51813c3c74d
  ?>
