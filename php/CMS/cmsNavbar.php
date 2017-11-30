<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsNavbar.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php"); ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
        </script>

        <div id="pageContent">


            <table id="navbarTable"></table>

            <div id="test"></div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {

                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Navbar ORDER BY position;"},
                        success: function(data, status) {*/
                              //De beste manier om het woord array te spellen
//                            for (i = 0; i < data.length; ++ i) {
//                               $("#navbarTable").append("<tr><td>"+data[i][2]+"</td><td>"+data[i][0]+"</td><td>"+data[i][1]+"</td></tr>");
//                            }

                            var json = data;
                            var data = $.parseJSON(json);

                            $("#navbarTable").append("<tr><th>Order</th><th>URL</th><th>Name</th></tr>");
                            for (i = 0; i < data.length; ++ i) {
                                $("#navbarTable").append("<tr><td class='position'>"+data[i][2]+"</td><td class='url'>"+data[i][0]+"</td><td class='name'>"+data[i][1]+"</td><td><button class='edit'></td></tr>");
                            }

                            //Add listeners to edit buttons
                            var buttons[] = $(".edit");
                            alert(buttons.length);
                        }
                      });
                });
            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
