<?php
    require("../scripts/GlobalFunctions.php");
    require("../scripts/databaseConnection.php");

    $array = scandir("../images/Referenties");
    $imgs = $array;

    for ($i = 0; $i < count($array); ++ $i) {
        if ($imgs[$i] == "." || $imgs[$i] == ".." || $imgs[$i] == "old") {
            array_splice($imgs, $i, 1);
        }
    }

    for ($i = 0; $i < count($imgs); ++ $i) {
        print($i.": ".$imgs[$i]."<br>");
    }

    print("<br><br>".count($imgs)."<br><br>");

    for ($i = 0; $i < count($imgs); ++ $i) {
        print("$i: <img height='50px' title='".$imgs[$i]."' src='../images/Referenties/".$imgs[$i]."' alt='".$i."'><br>");
    }

 ?>
