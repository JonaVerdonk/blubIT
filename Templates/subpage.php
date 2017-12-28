<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Template</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
  </head>
  <body>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109575524-1');
    </script>

      <?php include_once("../../scripts/databaseConnection.php") ?>
      <?php include("../../scripts/header.php"); ?>
      <?php include("../../scripts/content.php"); ?>
      <?php include("../../scripts/footer.php"); ?>
  </body>
</html>
