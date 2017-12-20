<?php
//When called echo an array of items //Text and images//
include_once("../../../scripts/databaseConnection.php");

//Clean the POST
$newString = filter_input(INPUT_POST, "newString", FILTER_SANITIZE_SPECIAL_CHARS);
$ContentID = filter_input(INPUT_POST, "ContentID", FILTER_SANITIZE_SPECIAL_CHARS);
$table = filter_input(INPUT_POST, "type", FILTER_SANITIZE_SPECIAL_CHARS);

//Filtering
$filter = array("img","text");
if(!in_array($table, $filter)){
  echo json_encode("invalid type");
  return;
}

if(is_nan($ContentID)){
  echo json_encode("invalid id");
  return;
}

if($table == "img"){
  //table is img

  //rename table to correct name
  $table = "Image";

  //execute an update
  //executeSQL("UPDATE $table SET url=""");
}else{
  //table is text

  //rename table to correct name
  $table = "Text";

  //execute an update
  echo json_encode("UPDATE $table SET content='$newString' WHERE contentID=$ContentID");
  executeSQL("UPDATE $table SET content='$newString' WHERE contentID=$ContentID");
}

//execute an update
//executeSQL("UPDATE $table SET ")

//output format: unique id of element, Url/content, type, contentID
//echo json_encode($Content);
 ?>
