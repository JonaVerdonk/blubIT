
<?php

include("CMSContentTools.php");
//GET a list of all the contentboxes in the pages
  //GET URL
$url = $_SERVER['PHP_SELF'];
  // SET QUERRY
$query = "SELECT contentID, position, type FROM Content WHERE url = \"" . $url . "\"";
 // Execute Query
$array = executeSQL($query, 1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='/css/content.css'> <div id='content'>"; //Adds the styling
  //Cycle through the array
foreach($array as $indexMain => $Record){
    //Get Data inside the record
  $ContentID = $Record["contentID"];
  $position = $Record["position"];
  $Type = $Record["type"];

  $position = explode(",", $position);
  $positionString = $position[2] . " / " . $position[0] . " / span " . $position[3] . " / span " . $position[1];
    //Creates the div
  echo "<div class='content-body $ContentID' style='grid-area: " . $positionString . "'>";
  echo "<div style='display: none'></div>"; //Fixes some weird bug in firefox where white backgrounds appears
  if($Type == "text" || empty($Type)){
     //Get all the text fields in the contentBox
    $textFields = executeSQL("SELECT content, id FROM Text WHERE contentID = $ContentID LIMIT 1");
     //Cycles and prints all texts
    foreach ($textFields as $key => $value) {
      echo "<p class = '$value[1] $Type'>" . $value[0] . "</p>";
    }
    if(empty($Type)){
      echo "<p class = '$value[1] $Type'>" . $value[0] . "</p>";
      echo empty($Type) . " " . $Type;
      executeSQL("UPDATE Content SET type='text' WHERE contentID = $ContentID");
      executeSQL("INSERT INTO Text(contentID,content) VALUES($ContentID,'[HANDLE]')");
    }
  }else if($Type == "img"){
     //Get all the images in the contentBox
    $ImageFields = executeSQL("SELECT width,height,alt,url FROM Image WHERE contentID = $ContentID LIMIT 1");

    foreach ($ImageFields as $key => $value) {
      echo "<img class='$Type' style='width: $value[0]%;height: $value[1]px' alt='$value[2]' src='$value[3]'>";
    }
  }else{
    echo "<p>DUD</p>";
    executeSQL("UPDATE Content SET type = 'text' WHERE contentID = $ContentID");
  }
  echo"</div>";
}

echo "</div>";
 ?>
