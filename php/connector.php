<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
  <title>Connector page</title>
</head>
<body>
  <?php include("../scripts/header.php");?>
  <script src="/js/Connector.js"></script>

  <div class="Head-box">
    <img id="imgbig" src="../images/Bigimage.jpg" alt="">
  </div>

  <div class="test">
    <div id="pageContent">
    <h2>Connector Informatie</h2>
    <input type="radio" id="all" name="category" checked> <div id="radio-color"> Alle Connectors</div>
    <input type="radio" id="singlemode" name="category"> <div id="radio-color"> Single-mode Connectors</div>
    <input type="radio" id="multimode" name="category"> <div id="radio-color"> Multi-mode Connectors</div>

    <!-- Portfolio Gallery Grid -->
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
          <div class='column $ConType'>
            <div class='content'>
              <img id='imgklein' src='$ConImg' alt='$ConType' style='width:100%'>
              <h4>$ConName</h4>
              <p>$ConText</p>
              <input class=boxer type=checkbox name=connector[] value=connector1>
            </div>
          </div>";
      }
       ?>
      <!-- END GRID -->
      <input title='Toevoegen aan contactformulier' class="save-button" type="submit" name="save" value="Opslaan">
    </form>
    </div>

  </div>
  <?php include '../scripts/footer.php';?>
</body>
</html>
