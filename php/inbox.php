<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" initial-scale="1.0">
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/analytics.css">
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
        
    </div>
</div>

<?php include("../scripts/footer.php"); ?>
</body>
</html>
