<?php
session_start();
include_once("/scripts/databaseConnection.php");
include_once("../scripts/Saltypassword.php");
include_once("../scripts/GlobalFunctions.php");


//Wanneer de button deleteuser is ingedrukt wordt de SQL query uitgevoerd dat de user wordt verwijderd.
if (isset($_POST['deleteuser'])){
    print "quary";
    $newuserid = $_POST['userid'];
    print $newuserid;
    executeSQL ("DELETE FROM User WHERE userId='$newuserid';");
    header ('Location: users.php');
    exit;
}
//Wanneer de button Save is ingedrukt wordt de SQL query uitgevoerd die de user update.

if (isset($_POST['btn-edit'])){
    print "edit tha quary";
    $newusername = $_POST['userName'];
    $newuseremail = $_POST['userEmail'];
    $newuserid = $_POST['userid'];
    $pass = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $role = $_POST['role'];

    if ( !filter_var($newuseremail,FILTER_VALIDATE_EMAIL) ) {
      $error = TRUE;
      $errorMsg  = "Voer a.u.b. een geldig emailadres in. ";
    }

    // Check of het password leeg is.
    if ( empty($pass) && !$error){
      //Username, Email en role worden standaard geupdate.
        executeSQL ("UPDATE User SET userName = '$newusername', userEmail = '$newuseremail', role = '$role' WHERE userId = $newuserid;");

      //Wanneer de query is uitgevoerd ga je terug naar de user pagina.
      header ('Location: users.php');
      exit;

      //Password wordt gechecked op verschillende eisen.
    } else if(strlen($pass) < 6) {
      $error = TRUE;
      $errorMsg  = "Het wachtwoord moet uit minimaal 6 tekens bestaan.";
    } else if($pass !== $confirmpassword){
      $error = TRUE;
      $errorMsg  = "De wachtwoorden komen niet overeen.";
    }

     // Password wordt nu geencrypt SHA256();
    $password = hash('sha256', $pass);

     //Het password wordt nu gesalt (cost 10).
    $password = HashPass($password);

    //Wanneer er geen foutmelding is wordt nu alles over de user geupdate, inclusief password.
    if (!$error){
    executeSQL ("UPDATE User SET userName = '$newusername', userEmail = '$newuseremail', userPass = '$password', role = '$role' WHERE userId = $newuserid;");

    //Wanneer de query is uitgevoerd ga je terug naar de user pagina.
    header ('Location: users.php?$edited=true');
    exit;

  }else{
      //Houston, we've got a problem.
      print ("ERROR: ");
      print ($errorMsg);
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
         <link rel="stylesheet" type="text/css" href="../css/edituser.css">

         <title></title>
     </head>
     <body>
       <?php include("../scripts/header.php");
       if ($_SESSION['role'] !== 'x') {
           header("Location: redirect.php");
       }
       include("../scripts/header.php");
       $userid = $_POST["userid"];
       ?>

       <div id="pageContent">


    <?php

       $edituser = executeSQL ("SELECT userId, userName, userEmail, role FROM User WHERE userId = $userid", 2);

       ?>
       <div class="btnBack">
           <a href="users.php">Terug</a>
       </div>
       <div id="both">
       <h1>Aanpassen gebruikersgegevens</h1>
       <form id="edituser" method="POST" action="" onsubmit="return confirm('You sure');">
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
          </select></br></td></tr><table>
              <input type="submit" id="deleteuser" name="deleteuser" value="Gebruiker verwijderen">
          <input type="submit" id="btnSave" name="btn-edit" class="notClickable" value="Save">
        </form>
      </div>






        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>
        $(document).ready(function() {
            $("input").on("change",function(){
                changed();
            });

            function changed() {
                //Every time this function is called add class clickable and remove notClickable to the save btn.
                $("#btnSave").addClass("clickable");
                $("#btnSave").removeClass("notClickable");

                //Add an event listener to the save btn, but unbind it first so it is never called twice.
                $("#btnSave").unbind("click");
                $("#btnSave").on("click", function() {
                    //When clicked, set its class to notClickable
                    $("#btnSave").addClass("notClickable");
                    $("#btnSave").removeClass("clickable");
                });
            }
        });

        </script>

    <?php include("../scripts/footer.php");
  ?>

    </body>
</html>
