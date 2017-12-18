<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsSubpage.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        include_once("/scripts/databaseConnection.php");
        if ($_SESSION['role'] !== 'x') {
            header("Location: /php/redirect.php");
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
        <script>
          function LoadFile(){
            //Get list of all editable items on the page
            //Input url => all editable items
            var selected = $(".File").val();
            console.log(selected);
            switch(selected){
              case "NewSubpag": newSubPage(); break;
            }
          }

          function newSubPage(){
            $("body").append("<div id='Message'><div id='Message-header'>Subpage creatie</div><div id='Message-body'>Er zal een subpage worden gemaakt, hierbij is bevestiging nodig</div><div id='Message-buttons'><div id='Message-buttons-bevestig'>Bevestig</div><div id='Message-buttons-cancel'>cancel</div></div></div>");
          }
        </script>

        <select class="File" name="" onchange="LoadFile()">
        <!-- Make dropdown -->
        <?php
        //Get all known subpages
        $Subpages = scandir("../subpages");
        $Subpages = array_diff($Subpages, array('..', '.'));

        //loop through all known pages
        foreach ($Subpages as $index => $Record) {
          //for each record print as option
          echo "<option value='" . $Record . "'>" . $Record . "</option>";
        }
        ?>
        <option value='NewSubpag'>new subpage</option>
        </select>

        <?php include("/scripts/footer.php"); ?>
    </body>
</html>
