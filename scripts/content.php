<?php
include("databaseConnection.php.php");
$contentAdmin = true;

$array = array(1,2,3,1,2,3,1,2,3,1,2,3,1,2,3,1,2,3);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='css/content.css'> <div id='content'>"; //Add the styling
  //Cycle through the array
foreach ($array as $index => $ContentID) {
    //Create a div
  echo "<div class='content-body'>";
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
