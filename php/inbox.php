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
                        <?php
                            // include_once ("../scripts/databaseConnection.php");
                            // $msg = executeSql("SELECT * FROM Message ORDER BY timestamp DESC;" , 2);
                            // for ($i = 0; $i < count($msg); $i ++) {
                            //     print  "<div class='form' id='".$i."'>";
                            //     print  "<span id='subjectPreview'>" . $msg[$i][7] . "</span><br>";
                            //     print  "<span id='namePreview'>" . $msg[$i][4] . " " . $msg[$i][5] . "</span>";
                            //     print  "</div>";
                            // }
                        ?>
                    </div>
                    <div id="formReader">
                        <p id="sendInfo">Verzonden door <span id="name"></span> via <span id="email"></span> op <span id="timestamp"></span></p>
                        <div id="actions"><span id="delete">&#10008;</span></div>
                        <h2 id="subject"></h2>
                        <p id="message"></p>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                //$(document).ready(function() {
                    print();
                //});

                function print() {
                    $.ajax({
                        url: "../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Message ORDER BY timestamp DESC;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            data = $.parseJSON(json);

                            //Print all messages on the left side
                            for (var i = 0; i < data.lengthl ++ i) {
                                var name = data[i][4]+" "+data[i][5];
                                $("#formList").append("<div class='form' id='i'><span id='subjectPreview'>"+data[i][7]+"</span><br><span id='namePreview'>"+name+"</span></div>");
                            }

                            messages = $(".form");

                            messages.on("click", function() {
                                msg = $(this).attr("id");
                                $("#name").     html(data[msg][4] + " " + data[msg][5]);
                                $("#email").    html(data[msg][6]);
                                $("#timestamp").html(data[msg][2]);
                                $("#subject").  html(data[msg][7]);
                                $("#message").  html(data[msg][8]);
                            });
                            messages[0].click();

                            $("#delete").on("click", function() {
                                if (confirm("Weet je zeker dat je dit bericht wil verwijderen?")) {
                                    deleteMsg(data[msg][0]);
                                }
                            });
                        }
                    });
                }

                function deleteMsg(id) {
                    $.ajax({
                        url: "../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "DELETE FROM Message WHERE messageId="+id+";"},
                        success: function(json, status) {
                            location.reload();
                        }
                    });
                }
            </script>
        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
