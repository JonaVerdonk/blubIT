<?php

//Root of image folder
$root = "../../../images";

//Get all content from url
function find_all_files($dir){
  $scan = scandir($dir);
  foreach ($scan as $value) {
    if($value === '.' || $value === '..'){continue;}
    if(is_file("$dir/$value")){$result[]="$dir/$value";continue;}
    foreach(find_all_files("$dir/$value") as $value){
      $result[]=$value;
    }
  }
  return $result;
}

//output format: unique id of element, Url/content, type, contentID

echo json_encode(find_all_files($root));
 ?>
