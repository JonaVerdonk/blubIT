
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

            <!-- Wanneer er is ingelogd/geregistreerd wordt er een bericht getoond dat er succesvol is ingelogd/geregistreerd.  -->
          <?php if (isset ($registered) || isset ($login)) {
            print ('<div id="notificationgood">');
            print ($registered . $login);
            print ('</div>');
          }


          // Wanneer er iets fout gaat bij het inloggen/registreren krijg wordt er een foutmelding getoond.
            if ($error || $errorLogin){
              print ('<div id="notificationerror">');
              print ($errorMsg . $errorLoginMsg);
              print ('</div>');
            }
          ?>


          <div="both">

          <!-- Loginscherm wordt getoond.  -->
            <div id="login">
              <h1>Login</h1>
                <form method="POST" action="">
                    E-mailadres: <input type="email" name="email" placeholder="Uw emailadres" value="" maxlength="40"><br>
                    <span class="text-danger"></span><br>
                    Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Uw wachtwoord" maxlength="40"><br>
                    <br><input type="submit" name="btn-login" class="btnStandard">
                </form>

            </div>

            <!-- Registreer scherm wordt getoond.  -->
            <div id="register">
              <h1>Registreren</h1>
            <form method="POST" action="" secret="6LcD6D0UAAAAAGEF30jHYE8_p2Sn2S3nGjLUYihj">
              Volledige naam: <input type="text" name="name" placeholder="Naam" maxlength="45"><br>
              <span class="text-danger"></span><br>
              E-mailadres: <input type="email" name="email" placeholder="E-mailadres" value="" maxlength="40"><br>
              <span class="text-danger"></span><br>
              Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Wachtwoord" maxlength="40"><br>
              <span class="text-danger"></span><br>
              Bevestig password: <input type="password" name="confirmpass" class="form-control" placeholder="Bevestig Wachtwoord" maxlength="40"><br>
              <!--<br><div class="g-recaptcha" data-sitekey="6Lf26D0UAAAAAPfiQcHfLL_F6xm3h8zUb-tpH_3w"></div>-->
              <br><input type="submit" name="btn-signup" class="btnStandard">
            </form>
            </div>

          </div>
        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
