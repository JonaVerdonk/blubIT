<?php

    if (isset($_POST["submit"])) {
        unset($_POST["submit"]);

        include("../../scripts/databaseConnection.php");

        if ($_POST["query"] !== "") {
            executeSQL($_POST["query"]);
        } else {
            print("Invalid query");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
    </head>
    <body>

        <?php include("../../scripts/header.php");
        if ($_SESSION['role'] == 'x') {
            header("Location: redirect.php");
        }
        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
        </script>

        <div id="pageContent">

            <div class="btnBack">
                <a href="CMS.php">Terug</a>
            </div>

          <form id="ReadRef" action="ReadRef.php" method="post">
            <input type="submit" name="" value="Reload References">
          </form>

            <form action="" method="POST">
                <h2>Perform query</h2><br>
                <input type="text" name="query" style="width: 1000px;"><br>
                <input type="submit" name="submit">
            </div>

            <h3> Database gegevens inzien op <a href="https://mysql.transip.nl/">deze</a> site.</h3>

        </div>

        <?php include("../../scripts/footer.php"); ?>
    </body>
</html>
