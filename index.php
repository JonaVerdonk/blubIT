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

                    $data = executeSQL("SELECT * FROM Homepage");
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
                    }</style>");
                ?>

                <div id="Content-header-img"></div>
                <div id="Content-header-text"><?php print($data[0][1]); ?></div>
                <a href="#content-body" id="content-header-icon-anchor">
                <div id="content-header-icon">&#x2193;</div>
                </a>
            </div>

            <div id="content-body">
                <div id="content-body-item-container">
                    <?php
                        $data = executeSQL("SELECT * FROM HomepageItem ORDER BY 'order';");

                        for ($i = 0; $i < count($data); ++ $i) {
                            print("<div class='content-body-item'>");
                            print("<img src='".$data[$i][1]."' alt='itemImg'>");
                            print("<h2>".$data[$i][2]."</h2>");
                            print("<p>".$data[$i][3]."</p>");
                            if($data[$i][4] != "Geen lees meer pagina"){
                              print("<div><a href='php/subpages/" . $data[$i][4] . "'>Lees meer</a></div>");
                            }
                            print("</div>");
                        }
                    ?>
                </div>
            </div>
        <?php include("scripts/footer.php"); ?>
    </body>
</html>
