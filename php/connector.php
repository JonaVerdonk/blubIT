<!DOCTYPE html>
<html>
    <head>
          <?php include_once "../scripts/databaseConnection.php"; ?>

          <meta charset="UTF-8">
          <link rel="stylesheet" href="../css/Connector.css" type="text/css">
          <link rel="stylesheet" type="text/css" href="../css/style.css">
          <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
          <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
          </script>
          <title>Connectors kiezen</title>
    </head>

    <body>
        <?php include("../scripts/header.php");?>
        <script src="/js/Connector.js"></script>

        <div class="Head-box">
            <img id="imgbig" src="../images/Bigimage.jpg" alt="">
        </div>

        <div id="pageContent">
            <h2>Connector Informatie</h2>
            <p>Indien u uw glasvezel wilt laten meten, selecteer de connector(en) die u heeft  en neem meteen contact op door onderaan de pagina op "opslaan" te klikken!</p>

            <input type="radio" id="all"  name="category" checked> <div id="radio-color"> Alle Connectors</div>
            <input type="radio" id="singlemode"  name="category"> <div id="radio-color"> Single-mode Connectors</div>
            <input type="radio" id="multimode" name="category"> <div id="radio-color"> Multi-mode Connectors</div>

            <form method="get" action="contact.php">
                <?php
                    $result = executeSQL("SELECT connector_ID, connector_type, connector_image, connector_name, connector_text FROM Connector", 1);

                    foreach ($result as $index => $Record) {
                        $ConID = $Record["connector_ID"];
                        $ConType = $Record["connector_type"];
                        $ConImg = $Record["connector_image"];
                        $ConName = $Record["connector_name"];
                        $ConText = $Record["connector_text"];

                        echo"
                        <div class='square'>
                          <div class='column $ConType'>
                            <div class='content'>
                              <img id='imgklein' src='$ConImg' alt='$ConType' style='width:100%'>
                              <h4>$ConName</h4>
                              <p>$ConText</p>
                              <input class='boxer' type='checkbox' name=connector[] value='$ConName'>
                            </div>
                          </div>
                        </div>";
                    }
                ?>

                <input title='Toevoegen aan contactformulier' class="btnStandard" type="submit" name="save" value="Opslaan">
            </form>
        </div>

        <?php include '../scripts/footer.php';?>
    </body>
</html>
