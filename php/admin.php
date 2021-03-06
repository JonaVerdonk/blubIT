<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin pagina</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/admin.css">
    </head>
    <body>

        <?php
            include("../scripts/header.php");
            if ($_SESSION['role'] == 'r') {
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

            <div id="adminLinks">
                <div class="adminItem">
                    <a href="analytics.php">
                        <img src="../images/adminStatistics.png">
                        <p>Analytics</p>
                    </a>
                </div>

                <div class="adminItem">
                    <a href="CMS/CMS.php">
                        <img src="../images/adminCMS.png">
                        <p>CMS</p>
                    </a>
                </div>

                <div class="adminItem">
                    <a href="users.php">
                        <img src="../images/adminUsers.png">
                        <p>Gebruikers</p>
                    </a>
                </div>

                <div class="adminItem">
                    <a href="log.php">
                        <img src="../images/adminLog.png">
                        <p>Logs</p>
                    </a>
                </div>

                <div class="adminItem">
                    <a href="inbox.php">
                        <img src="../images/adminEmail.png">
                        <p>Inbox</p>
                    </a>
                </div>

                <!-- <div class="adminItem">
                    <a href="ImageUpload.php">
                        <img src="../images/adminImage.png">
                        <p>Afbeeldingen uploaden</p>
                    </a>
                </div> -->
                <div class="adminItem">
                    <a href="https://www.google.com/teapot">
                        <img src="../images/teaAdmin.png">
                        <p>jolly cup of tea</p>
                    </a>
                </div>
                <div class="adminItem">
                    <a href="trex.php">
                        <img src="../images/adminTrex.png">
                        <p>Stress relief</p>
                    </a>
                </div>
            </div>

        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
