<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-109575524-1');
        </script>
    </head>
    <body>

        <?php include("scripts/header.php"); ?>
        <div id="content">
            <div id="content-header">
                <?php
                    include_once("scripts/databaseConnection.php");

                    $data = executeSql("SELECT * FROM Homepage");
                    //Printing the entire styling was the only way to get this to style corectly.
                    //Leaving all styling but the bg url in the stylesheet applies only some(none?) of the styling
                    print("<style>#Content-header-img {
                        width: 100%;
                        height: 100%;
                        background: url('".$data[0][0]."') no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                        height: 90vh;
                        position: absolute;
                        border-bottom: 3px double rgb(38, 72, 123);
                    }</style>")
                ?>

                <div id="Content-header-img"></div>
                <div id="Content-header-text"><?php print($data[0][1]); ?></div>
                <a href="#content-body" id="content-header-icon-anchor">
                <div id="content-header-icon">&#x2193;</div>
                </a>
            </div>

            <div id="content-body">
                <div id="content-body-item-container">
                    <div class="content-body-item">
                        <img src="images/Montage/Krimpen GCO poort (2).jpg" alt="">
                        <h2>Item</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>

                    <div class="content-body-item">
                        <img src="images//Montage/GPS2 Las patch lade (1).jpg" alt="">
                        <h2>Item</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>

                    <div class="content-body-item">
                        <img src="images/Lasmachine/DSC02640.jpg" alt="">
                        <h2>Item</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
        <?php include("scripts/footer.php"); ?>
    </body>
</html>
