<?php

if (!isset($_SESSION["role"])) {
$_SESSION["role"] == "w" OR "x";
}

        include_once("databaseConnection.php");

        $links = executeSQL("SELECT * FROM Navbar ORDER BY position");
 
?>

<head>
    <title><?php $ntitle ?></title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>
    <?php include("../scripts/header.php"); ?>
        <div id="pageContent">

        </div>

    <?php include("../scripts/footer.php"); ?>
</body>
