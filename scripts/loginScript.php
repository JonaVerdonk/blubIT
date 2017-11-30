<?php
  session_start();
  include("../scripts/databaseConnection.php.php");

// it will never let you open index(login) page if session is set
// if ( isset($_SESSION['user'])!="" ) {
//  header("Location: home.php");
//  exit;
// }

$error = false;
print "stap1";
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
print "okdoei";
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
print "blub1";
 // if there's no error, continue to login
 if (!$error) {
print "blub2";
  $password = hash('sha256', $pass); // password hashing using SHA256
  print "blub3";
  //$res = executeSQL ("SELECT userId, userName, userPass FROM User WHERE userEmail='$email'", 0);
   testFunction();
  //print "blub90";
 // for ($i = 0; $i < count($res); ++$i){
    // print("userID " . $res["userId"]);
    //  print("userName " . $res["userName"]);
    //   print("userPass " . $res["userPass"]);
 }
  // $row = $res;
  // $count = count($res); // if uname/pass correct it returns must be 1 row

print "hoi";
  if( $count == 1 && $row[0]['userPass']==$password ) {
   $_SESSION['user'] = $row['userId'];
   header("Location: index.php");
  // print("AAAAAAH");
  } else {
    //print("BBBBBBBBH");
   $errMSG = "Incorrect Credentials, Try again...";
  }

 }
print "jaaa";
//}
?>
