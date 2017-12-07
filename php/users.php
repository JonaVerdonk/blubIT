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
       <?php include("../scripts/header.php");
       if ($_SESSION['role'] !== 'x') {
           header("Location: redirect.php");
       }
       ?>
       <div id="pageContent">

       <?php
        $users = executeSQL ("SELECT userId, userName, userEmail, role FROM User", 2);
        //print_r ($users);

        print ("<table id=table>");
        print ("<tr>
                  <th>Gebruikers ID</th>
                  <th>Volledige naam</th>
                  <th>E-mail adres</th>
                  <th>Rechten</th>
                  <th>Edit</th>
              </tr>");

          for ($i = 0; $i < count($users); ++ $i) {
            print ("<tr id='$i'>");
              for($j = 0; $j < count($users[$i]); ++ $j) {
                print ("<td class='$j'>");
                print ($users[$i][$j]);
                print ("</td>");
              }
              print ("<td><button value='$i' class='edit'>Edit</button></td>");
            print ("</tr>");
          }
        print ("</table>");
        ?>
        <form id="form" method="POST" action="edituser.php">
          <input type="text" name="userid" id="userid">
          <input type="submit" id="submit">
        </form>

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
