<?php

include("../scripts/loginScript.php");
include("../scripts/registerScript.php");

?>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1" async defer></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-109575524-1');
        </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <title></title>
    </head>
    <body>
        <?php include("../scripts/header.php"); ?>



        <div id="pageContent">

          <?php if (isset ($registered) || isset ($login)) {
            print ('<div id="notificationgood">');
            print ($registered . $login);
            print ('</div>');
          }?>

          <?php
            if ($error || $errorLogin){
              print ('<div id="notificationerror">');
              print ($errorMsg . $errorLoginMsg);
              print ('</div>');
            }
          ?>

          <div="both">
            <div id="login">
              <h1>Login</h1>
                <form method="POST" action="">
                    E-mailadres: <input type="email" name="email" placeholder="Your Email" value="" maxlength="40"><br>
                    <span class="text-danger"></span><br>
                    Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="40"><br>
                    <input type="submit" name="btn-login">
                </form>

            </div>

            <div id="register">
              <h1>Registreren</h1>
            <form method="POST" action="">
              Volledige naam: <input type="text" name="name" placeholder="Naam" maxlength="45"><br>
              <span class="text-danger"></span><br>
              E-mailadres: <input type="email" name="email" placeholder="E-mailadres" value="" maxlength="40"><br>
              <span class="text-danger"></span><br>
              Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Wachtwoord" maxlength="40"><br>
              <span class="text-danger"></span><br>
              Bevestig password: <input type="password" name="confirmpass" class="form-control" placeholder="Bevestig Wachtwoord" maxlength="40"><br>
              <input type="submit" name="btn-signup">
          </form>
                <form method="POST" action="?" secret="6Led1zsUAAAAAJ-pZ1hIcAzudqKLOV-c5DkriEk9">
<!--                <div class="g-recaptcha" data-sitekey="6Led1zsUAAAAABQyTyfLAAvxtJOYxp4rmGt2xn1j"></div>
                    <input type="submit" value="Submit"> -->
                </form>
            </div>

          </div>
        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
