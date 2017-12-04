<?php
include_once("databaseConnection.php");
 ?>

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

         <meta name="viewport" content="width=device-width" initial-scale="1.0">
         <link rel="stylesheet" type="text/css" href="../css/style.css">
         <title></title>
     </head>
     <body>
       <?php include("../scripts/header.php"); ?>
       <div id="pageContent">

       <?php
        $users = executeSQL ("SELECT userId, userName, userEmail, role FROM User", 2);
        //print_r ($users);

        print ("<table>");
          for ($i = 0; $i < count($users); ++ $i) {
            print ("<tr>");
              for($j = 0; $j < count($users[$i]); ++ $j) {
                print ("<td>");
                print ($users[$i][$j]);
                print ("</td>");
              }
            print ("</tr>");
          }
        print ("</table>");

        ?>




    <?php include("../scripts/footer.php"); ?>

    </body>
</html>
