<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/admin.css">
    </head>
    <body>

        <?php include("../scripts/header.php"); ?>

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
                Dit is een github test. ignore.
                <div class="adminItem">
                    <a href="../php/analytics.php">
                        <img src="../images/350x150.png">
                        <p>Test</p>
                    </a>
                </div>
                
                <div class="adminItem">
                    <a href="../php/CMS.php">
                        <img src="../images/350x150.png">
                        <p>CMS</p>
                    </a>
                </div>
                
                <div class="adminItem">
                    <a href="#">
                        <img src="../images/350x150.png">
                        <p>Users</p>
                    </a>
                </div>
            </div>
            
        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
