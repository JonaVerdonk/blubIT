<?php

include("../scripts/loginScript.php");
include("../scripts/registerScript.php");

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
          <div="both">
            <div id="login">
              <h1>Login</h1>
              <?php print $errorMsg ?>
                <form method="POST" action="">
                    E-mailadres: <input type="email" name="email" placeholder="Your Email" value="" maxlength="40"><br>
                    <span class="text-danger"></span><br>
                    Wachtwoord: <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="40"><br>
                    <input type="submit" name="btn-login">

                    <span><?php if ($error) {print($errorMsg);} ?></span>
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

              <span><?php if ($error) {print($errorMsg);} ?></span>
          </form>
            </div>
          </div>
        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
