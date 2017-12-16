<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsNavbar.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
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

        <div id="pageContent">

            <div class="btnBack">
                <a href="CMS.php">Terug</a>
            </div><br><br>

            <table id="navbarTable"></table>
            <br><br>
            <button id="btnSave" class="notClickable">Save</button>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    var data;

                    //Ajax request to get the data from the database.
                    //The executeQuery.php returns a JSON string
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Navbar ORDER BY position;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            data = $.parseJSON(json);

                            

                        }
                    });


            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
