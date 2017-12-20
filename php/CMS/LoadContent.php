<?php
//When called echo an array of items //Text and images//
include_once("../../scripts/databaseConnection.php");

//Clean the POST
$SelectedUrl = filter_input(INPUT_POST, "url", FILTER_SANITIZE_SPECIAL_CHARS);

//Get all content from url
$Contentboxes = executeSQL("SELECT ContentID FROM Content WHERE url = '/php/subpages/" . $SelectedUrl . "'", 2);

//Make content array
$Content = array();
foreach ($Contentboxes as $index => $Record) {
  //get all textfields
  $text = executeSQL("SELECT content FROM Text WHERE contentID = '" . $Record[0] . "'", 2);

  //Add all the images
  $image = executeSQL("SELECT url FROM Image WHERE contentID = '" . $Record[0] . "'", 2);

  //Error handling //Not a pure element
  if(count($text) + count($image) != 1){
    echo json_encode("Too many elements in " . $Record[0]);
    return;
  }

  //Add to array
  if(empty($text)) {
    //text is empty
     $Content[] = $image[0];
     $Content[$index][] = "img";
  }else{
    //$image is empty
    $Content[] = $text[0];
    $Content[$index][] = "text";
  }

  //Add contentid to recently added array
  $Content[$index][] = $Record[0];

}

//output format: unique id of element, Url/content, type, contentID
echo json_encode($Content);
 ?>
