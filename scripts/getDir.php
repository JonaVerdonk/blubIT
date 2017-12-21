<?php
    require("databaseConnection.php");

    //Get whole dir
    $array = scandir("../".$_POST["dir"]);

    //Remove dots at the beginning of the array
    $a = array_diff($array, [".", ".."]);

    //Move the whole array two back to account for the two null-values and the 'dir' value
    // for ($i = 0; $i < count($a); ++ $i) {
    //     $a[$i] = $a[$i+2];
    // }

    $a = array_filter($a);
    $a = array_values($a);

    //Filter out all folders
    for ($i = 0; $i < count($a); ++ $i) {
        if (!fnmatch("*.*", $a[$i])) {
            $folders[] = $a[$i];
            unset($a[$i]);
        }
    }

    $a = array_filter($a);

    $data[1] = $folders;

    $data[2] = array_values($a);

    $data[0][0] = $_POST["dir"];
    $data[0][1] = $_POST["el"];

    //Return the final array
    echo json_encode($data);

?>
