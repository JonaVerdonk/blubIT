
<?php
include("databaseConnection.php.php");
$contentAdmin = true;

//GET a list of all the contentboxes in the pages
  //GET URL
$url = $_SERVER['PHP_SELF'];
  // SET QUERRY
$query = "SELECT contentID,height FROM Content WHERE url = \"" . $url . "\"";
 // Execute Query
$array = executeSQL($query, 1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='css/content.css'> <div id='content'>"; //Add the styling
  //Cycle through the array
  for($i = 0; $i < 100; $i++){
foreach($array as $indexMain => $Record){
    //Get Data inside the record
  $ContentID = $Record["contentID"];
  $ContentHeight = $Record["height"]; //Short,medium,long auto,or px
    //Set height
  switch($ContentHeight){
    case "short": $ContentHeight = "20vh"; break; //20vh
    case "medium": $ContentHeight = "40vh"; break; //40vh
    case "long": $ContentHeight = "80vh"; break; //80vh
    case "auto": break;
    default: $ContentHeight = $ContentHeight . "px"; break; //Px
  }
    //Create the div
  echo "<div class='content-body col-sm-3' style='height: $ContentHeight'>";
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
}

echo "</div>";
 ?>
