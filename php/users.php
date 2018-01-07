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
         <link rel="stylesheet" type="text/css" href="../css/users.css">
         <title></title>
     </head>
     <body>
       <?php
           include("../scripts/header.php");

           //Er wordt een check gedaan of de ingelogde gebruiker wel de juiste rechten heeft.
           //Alleen execute rechten zijn toegelaten.
           if ($_SESSION['role'] !== 'x') {
               header("Location: redirect.php");
               exit;
           }
       ?>
       <div id="pageContent">

         <div class="btnBack">
             <a href="admin.php">Terug</a>
         </div><br><br>

       <?php

       //Alle users worden opgehaald uit de datebase.
        $users = executeSQL ("SELECT userId, userName, userEmail, role FROM User", 2);

        //Tabel wordt aangemaakt waarin de users worden laten zien.
        print ("<table id=table>");
        print ("<tr>
                  <th>Gebruikers ID</th>
                  <th>Volledige naam</th>
                  <th>E-mail adres</th>
                  <th>Rechten</th>
                  <th>Edit</th>
              </tr>");

        //Elke user komt op een aparte row. Via een for statement worden alle users netjes op een rijtje getoond.
          for ($i = 0; $i < count($users); ++ $i) {
            print ("<tr id='$i'>");
              for($j = 0; $j < count($users[$i]); ++ $j) {
                print ("<td class='$j'>");
                print ($users[$i][$j]);
                print ("</td>");
              }

              //Elke rij heeft op het eind een edit knop. Hiermee kan je de geselecteerde user editten.
              print ("<td><button value='$i' class='btnStandard edit'>Wijzig</button></td>");
            print ("</tr>");
          }
        print ("</table>");
        ?>
        <form id="form" method="POST" action="edituser.php">
          <input type="text" name="userid" id="userid">
          <input type="submit" id="submit">
        </form>

        <!-- Door middel van javascript wordt er bepaald welke user er is aangeklikt wanneer er op de edit knop wordt gedrukt. Zo wordt het goede USERID aan de POST meegegeven.  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
          $(document).ready(function() {

            var btnEdit = $(".edit");
            btnEdit.on("click", function() {
                var row = $(this).val();
                var id = $("#"+row+" .0").html();

                $("#userid").val(id);
                $("#submit").click();
            });
          });
        </script>
    <?php include("../scripts/footer.php"); ?>

    </body>
</html>
