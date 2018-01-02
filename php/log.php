<?php
    //If the submit button is set, show the amount of rows that the user requested. default to 25
    if (isset($_POST["submit"])) {
        $rows = intval($_POST["rows"]);
    } else {
        $rows = 25;
    }
?>

<!DOCTYPE html>
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

        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="../css/log.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title></title>
    </head>
    <body>
        <?php
            include("../scripts/header.php");

            if ($_SESSION['role'] !== 'x') {
                header("Location: redirect.php");
                exit;
            }
        ?>
        <div id="pageContent">

            <div class="btnBack">
                <a href="admin.php">Terug</a>
            </div><br><br>

            <form action="" method="POST" id="logForm">
                <input type="text" placeholder="Rows" name="rows"><br><br>
                <input type="submit" class="btnStandard" name="submit">
            </form><br><br>

            <!--Create the table and add table headers-->
            <table id="logs">
                <tr><th>ID</th><th>Gebruiker ID</th><th>Naam</th><th>Datum/tijd</th><th>Verandering</th></tr>

                <?php
                    //Select all data from 'log' and the username that matches the userId in 'log' and limit the result to 'rows' amount
                    $logs = executeSql("SELECT logId, user, timestamp, message, userName FROM Log JOIN User ON user = userId ORDER BY logID DESC LIMIT $rows", 0);

                    //Print a new row in the table for every row in '$logs'
                    for ($i = 0; $i < count($logs); ++ $i) {
                        print("<tr><td>".$logs[$i][0]."</td><td>".$logs[$i][1]."</td><td>".$logs[$i][4]."</td><td>".$logs[$i][2]."</td><td>".$logs[$i][3]."</td></tr>");
                    }
                ?>

            </table>

        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
