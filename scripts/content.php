
<?php

include("CMSContentTools.php");
//GET a list of all the contentboxes in the pages
  //GET URL
$url = $_SERVER['PHP_SELF'];
  // SET QUERRY
$query = "SELECT contentID, position FROM Content WHERE url = \"" . $url . "\"";
 // Execute Query
$array = executeSQL($query, 1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='css/content.css'> <div id='content'>"; //Add the styling
  //Cycle through the array
foreach($array as $indexMain => $Record){
    //Get Data inside the record
  $ContentID = $Record["contentID"];
  $position = $Record["position"];

  $position = explode(",", $position);
  $positionString = $position[2] . " / " . $position[0] . " / span " . $position[3] . " / span " . $position[1];
    //Create the div
  echo "<div class='content-body $ContentID' style='grid-area: " . $positionString . "'>";
  echo "<div style='display: none'></div>"; //Fixes some weired bug in firefox where white backgrounds apear
    //Get all the textfields in the contentBox
  $textFields = executeSQL("SELECT content FROM Text WHERE contentID = $ContentID");
    //Cycle and print all text
  foreach ($textFields as $key => $value) {
    echo "<p>" . $value[0] . "</p>";
  }
    //Get all the images in the contentBox
  $ImageFields = executeSQL("SELECT width,height,alt,url FROM Image WHERE contentID = $ContentID");

  foreach ($ImageFields as $key => $value) {
    echo "<img style='width: $value[0]%;height: $value[1]px' alt='$value[2]' src='$value[3]'>";
  }
  echo"</div>";
}

echo "</div>";
 ?>
