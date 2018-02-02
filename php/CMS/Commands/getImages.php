<?php
//Allow usage of sessions
session_start();

//User needs to be logged in and authorized
if ($_SESSION['role'] == 'r' || $_SESSION['logged_in'] != 1) {
    header("Location: ../../redirect.php");
}
//Root of image folder
$root = "../../../images";

//Get all content from url
function find_all_files($dir){
  $scan = scandir($dir);
  foreach ($scan as $value) {
    if($value === '.' || $value === '..'){continue;}
    if(is_file("$dir/$value")){$result[]=str_replace("../../..","","$dir/$value");continue;}
    foreach(find_all_files("$dir/$value") as $value){
      $result[]=str_replace("../../..","",$value);;
    }
  }
  return $result;
}

//output format: unique id of element, Url/content, type, contentID

echo json_encode(find_all_files($root));
 ?>
