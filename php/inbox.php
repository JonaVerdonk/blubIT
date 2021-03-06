<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <meta charset="UTF-8">
        <title>Inbox</title>
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

            <div class="btnBack">
                <a href="admin.php">Terug</a>
            </div><br>

            <div id="inbox">
                <div id="headInbox">
                    <H1 id="title"> Contact Inbox </H1>
                </div>
                <div id="bodyInbox">
                    <div id="formList"></div>

                    <div id="formReader">
                        <p id="sendInfo">Verzonden door <span id="name"></span> via <span id="email"></span> op <span id="timestamp"></span>
                        <br><span id="company"></span></p>
                        <div id="actions"><span id="delete">&#10008;</span><span id="setUnread">&#9993;</span><span id="reply">&#8617;</span></div>
                        <h2 id="subject"></h2>
                        <p id="message"></p>
                        <div id="replybox"></div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="../js/inbox.js"></script>
        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
