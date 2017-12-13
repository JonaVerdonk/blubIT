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
                    $msg = executeSql("SELECT * FROM Message" , 2);
                    for ($i = 0; $i < count($msg); $i ++) {
                        print  "<div class='form'>";
                        print  "<p>" . $msg[$i][7] . "</p>";
                        print  "<p>" . $msg[$i][4] . " " . $msg[$i][5] . "</p>";
                        print  "</div>";
                    }
                ?>
            </div>
            <div id="formReader">
                <p> placeholder </p>
            </div>
        </div>
    </div>
</div>

<?php include("../scripts/footer.php"); ?>
</body>
</html>
