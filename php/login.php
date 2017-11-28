<?php
 session_start();

   include("../scripts/databaseConnection.php.php");

 // it will never let you open index(login) page if session is set
// if ( isset($_SESSION['user'])!="" ) {
//  header("Location: home.php");
//  exit;
// }

 $error = false;

 if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
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
   $row = $res;
   $count = count($res); // if uname/pass correct it returns must be 1 row


   if( $count == 1 && $row[0]['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    header("Location: home.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }

  }

 }
?>


<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-109575524-1');
        </script>

        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <title></title>
    </head>
    <body>
        <?php include("../scripts/header.php"); ?>

        <div id="pageContent">
          <div="beide">
            <div id="login">
              <h1>Login</h1>
                <form method="POST" action="">
                    E-mailadres: <input type="email" name="email" placeholder="Your Email" value="" maxlength="40"><br>
                    <span class="text-danger"></span><br>
                    Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15"><br>
                    <input type="submit" name="btn-login">
                </form>

            </div>

            <div id="register">
              <h1>Registreren</h1>
              Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15"><br>
              <span class="text-danger"></span><br>
              E-mailadres: <input type="email" name="email" placeholder="Your Email" value="" maxlength="40"><br>

              <input type="submit" name="btn-login">
            </div>
          </div>
        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
