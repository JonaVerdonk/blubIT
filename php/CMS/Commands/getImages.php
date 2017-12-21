<?php

//Root of image folder
$root = "../../../images";

//Get all content from url
function find_all_files($dir){
  //Scan folder
  $scan = scandir($dir);

  //Loop through all files in folder
  foreach ($scan as $Mainvalue) {
    //Not a dot or file
    if($Mainvalue === '.' || $Mainvalue === '..'){continue;}
    if(is_file("$dir/$Mainvalue")){$result[]="$dir/$Mainvalue";continue;}

    //Folder record
    foreach(find_all_files("$dir/$Mainvalue") as $value){
      $result[$Mainvalue][]=$value;
    }
  }
  return str_replace("../../..","",$result);
}



//output format: unique id of element, Url/content, type, contentID
echo json_encode(find_all_files($root));
 ?>
