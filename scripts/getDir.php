<?php
    require("databaseConnection.php");

    //Get whole dir
    $array = scandir("../".$_POST["dir"]);

    //Remove dots at the beginning of the array
    $array = array_diff($array, [".", ".."]);

    //Move the whole array two back to account for the two null-values and the 'dir' value
    for ($i = 0; $i < count($array); ++ $i) {
        $array[$i] = $array[$i+2];
    }

    //Filter out all folders
    for ($i = 1; $i < count($a); ++ $i) {
        if (!fnmatch("*.*", $a[$i])) {
            $folders[count($folders)] = $a[$i];
            unset($a[$i]);
        }
    }
    $data[1] = $folders;

    $data[2] = array_values($array);

    $data[0][0] = $_POST["dir"];
    $data[0][1] = $_POST["el"];

    //Return the final array
    echo json_encode($data);



 ?>
