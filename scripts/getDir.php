<?php

    //Get whole dir
    $array = scandir("../".$_POST["dir"]);

    //Remove dots at the beginning of the array
    $a = array_diff($array, [".", ".."]);

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

    //Data[1] contains all folders
    $data[1] = $folders;
    //Data[2] contains all files in current directory
    $data[2] = array_values($a);
    //data[0] contains data to make the img selection work. Not pretty, but it works.
    $data[0][0] = $_POST["dir"];
    $data[0][1] = $_POST["el"];

    //Return the final array
    echo json_encode($data);

?>
