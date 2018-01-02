<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/CMS.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        if ($_SESSION['role'] == 'r') {
            header("Location: ../redirect.php");
            exit;
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
                <a href="../admin.php">Terug</a>
            </div>

            <div id="container">
                <div class="btnStandard"><a href="cmsNavbar.php">Navigatiebalk</a></div><br>
                <div class="btnStandard"><a href="cmsHomepage.php">Homepagina</a></div><br>
                <div class="btnStandard"><a href="cmsSubpage.php">Subpagina's</a></div><br>
                <!--<div class="btnStandard"><a href="dbConnection.php">Database connection</a></div><br>-->
                <div class="btnStandard"><a href="cmsConnector.php">Connectoren</a></div>
            </div>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
