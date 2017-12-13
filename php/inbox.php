<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/inbox.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        if ($_SESSION['role'] == 'r') {
            header("Location: redirect.php");
            exit;
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
            <div id="inbox">
                <div id="headInbox">
                    <H1 id="title"> Contact Inbox </H1>
                </div>
                <div id="bodyInbox">
                    <div id="formList">
                        <p> forms </p>
                        <?php
                            include_once ("../scripts/databaseConnection.php");
                            $msg = executeSql("SELECT * FROM Message ORDER BY timestamp DESC;" , 2);
                            for ($i = 0; $i < count($msg); $i ++) {
                                print  "<div class='form' id='".$i."'>";
                                print  "<p>" . $msg[$i][7] . "</p>";
                                print  "<p>" . $msg[$i][4] . " " . $msg[$i][5] . "</p>";
                                print  "</div>";
                            }
                        ?>
                    </div>
                    <div id="formReader">
                        <h2 id="subject"></h2>
                        <p id="message"></p>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: "../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Message ORDER BY timestamp DESC;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            data = $.parseJSON(json);

                            messages = $(".form");

                            messages.on("click", function() {
                                msg = $(this).attr("id");
                                $("#subject").html(data[msg][7]);
                                $("#message").html(data[msg][8]);
                            });

                        }
                    });
                });
            </script>
        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
