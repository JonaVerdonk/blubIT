<?php
    if (isset($_POST["submit"])) {
        $rows = intval($_POST["rows"]);
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

            <form action="" method="POST" id="logForm">
                <input type="text" placeholder="Rows" name="rows"><br><br>
                <input type="submit" name="submit">
            </form><br><br>

            <table id="logs">
                <tr><th>ID</th><th>User ID</th><th>Name</th><th>Data/time</th><th>Change</th></tr>

                <?php
                    if (isset($rows)) {
                        $logs = executeSql("SELECT logId, user, timestamp, message, userName FROM Log JOIN User ON user = userId ORDER BY logID DESC LIMIT $rows", 0);
                    } else {
                        $logs = executeSql("SELECT logId, user, timestamp, message, userName FROM Log JOIN User ON user = userId ORDER BY logID DESC LIMIT 25", 0);
                    }
                    for ($i = 0; $i < count($logs); ++ $i) {
                        print("<tr><td>".$logs[$i][0]."</td><td>".$logs[$i][1]."</td><td>".$logs[$i][4]."</td><td>".$logs[$i][2]."</td><td>".$logs[$i][3]."</td></tr>");
                    }
                ?>

            </table>

        </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
