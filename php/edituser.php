<?php
session_start();
include_once("/scripts/databaseConnection.php");
include_once("../scripts/Saltypassword.php");
include_once("../scripts/GlobalFunctions.php");

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
         <link rel="stylesheet" type="text/css" href="../css/edituser.css">

         <title></title>
     </head>
     <body>
       <?php

        ?>
       <?php include("../scripts/header.php"); ?>
       <div id="pageContent">

       <?php

       $userid = $_POST["userid"];
       // $blub = testFunction();
       // print $blub;
       if (isset($_POST['btn-edit'])){
           $newusername = $_POST['userName'];
           $newuseremail = $_POST['userEmail'];
           $newuserid = $_POST['userid'];
           $pass = $_POST['password'];
           $confirmpassword = $_POST['confirmpassword'];
           $role = $_POST['role'];
           print ($role);
           //basic email validation
           if ( !filter_var($newuseremail,FILTER_VALIDATE_EMAIL) ) {
             $error = TRUE;
             $errorMsg  = "Voer a.u.b. een geldig emailadres in. ";
           }

           // password validation
           if (empty($pass) || (!$error)){
             //query uitvoeren zonder password update
             executeSQL ("UPDATE User SET userName = '$newusername', userEmail = '$newuseremail', role = '$role' WHERE userId = $newuserid;");
             header ('Location: users.php');
           } else if(strlen($pass) < 6) {
             $error = TRUE;
             $errorMsg  = "Het wachtwoord moet uit minimaal 6 tekens bestaan.";
           } else if($pass !== $confirmpassword){
             $error = TRUE;
             $errorMsg  = "De wachtwoorden komen niet overeen.";
           }
           print ("Voor hashing");
            // password encrypt using SHA256();
           $password = hash('sha256', $pass);
           print ("na hash");
            //Salt the password with cost of 15(Hardware difficulty) and PASSWORD_BCRYPT
           $password = HashPass($password);
           print ("Na salt");
           if (!$error){
           executeSQL ("UPDATE User SET userName = '$newusername', userEmail = '$newuseremail', userPass = '$password', role = '$role' WHERE userId = $newuserid;");
           header ('Location: users.php');
         }else{
           print ("in error");

           print ($errorMsg);
         }

       }else{
       $edituser = executeSQL ("SELECT userId, userName, userEmail, role FROM User WHERE userId = $userid", 2);

       ?>
       <div class="btnBack">
           <a href="users.php">Terug</a>
       </div>
       <div id="both">
       <h1>Pas hier de gegevens van de gebruiker aan</h1>
       <form id="edituser" method="POST" action="">
         <table>
          <tr><td>
              Gebruikers ID: </td><td> <input type="text" readonly name="userid" id="userid" value="<?php print ($edituser[0][0]); ?>"></br>
          </td></tr>
          <tr><td>
          Volledige naam: </td><td> <input type="text" name="userName" id="userName" value="<?php print ($edituser[0][1]); ?>"></br>
          </td></tr>
          <tr><td>
          Email adres: </td><td><input type="text" name="userEmail" id="userEmail" value="<?php print ($edituser[0][2]); ?>"></br>
        </td></tr>
        <tr><td>
          Wachtwoord (leeg laten om geen wijziging te maken): </td><td><input type="password" name="password" id="password"></br>
        </td></tr>
        <tr><td>
          Wachtwoord bevestigen: </td><td><input type="password" name="confirmpassword" id="confirmpassword"></br>
        </td></tr>
        <tr><td>
          Rechten:
          <?php
            if (($edituser[0][3]) == "x"){
              $rolex = true;
            }elseif (($edituser[0][3]) == "w"){
              $rolew = true;
            }else {
              $roler = true;
            }
          ?>
        </td><td>
          <select name="role">
            <option <?php if ($roler) {print "selected";} ?> value="r">Read</option>
            <option <?php if ($rolew) {print "selected";} ?> value="w">Write</option>
            <option <?php if ($rolex) {print "selected";} ?> value="x">Execute</option>
          </select></br>
          <input type="submit" id="btn-edit" name="btn-edit" value="bevestigen">
        </form></td></tr><table>
      </div>







        <script></script>

    <?php include("../scripts/footer.php");
  }?>

    </body>
</html>
