
<?php

include("CMSContentTools.php");
//GET a list of all the contentboxes in the pages
  //GET URL
$url = $_SERVER['PHP_SELF'];
  // SET QUERRY
$query = "SELECT contentID, position, type, row, kolomn FROM Content WHERE url = \"" . $url . "\" ORDER BY row,kolomn";
 // Execute Query
$array = executeSQL($query, 1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='/css/content.css'> <div id='content'>"; //Adds the styling

  //Cycle through the array
foreach($array as $indexMain => $Record){
    //Get Data inside the record
  $ContentID = $Record["contentID"];
  $position = $Record["position"];
  $Type = $Record["type"];

  $Row = $Record["row"];
  $Kolomn = $Record["kolomn"];

  $position = explode(",", $position);
  $positionString = $position[2] . " / " . $position[0] . " / span " . $position[3] . " / span " . $position[1];

  if(is_null($Row)){
    executeSQL("UPDATE Content SET row = $position[2] WHERE contentID = $ContentID;");
  }

  if(is_null($kolomn)){
    executeSQL("UPDATE Content SET kolomn = $position[0] WHERE contentID = $ContentID;");
  }
    //Creates the div
  echo "<div class='content-body $ContentID' style='grid-area: " . $positionString . "'>";
  echo "<div style='display: none'></div>"; //Fixes some weird bug in firefox where white backgrounds appears
  if($Type == "text" || empty($Type)){
     //Get all the text fields in the contentBox
    $textFields = executeSQL("SELECT content, id FROM Text WHERE contentID = $ContentID LIMIT 1");
     //Cycles and prints all texts
    foreach ($textFields as $key => $value) {
      echo "<p class = '$Type'>" . $value[0] . "</p>";
    }
    if(empty($Type)){ //Entry exists in content however no type //New content box
      //Set type to text
      executeSQL("UPDATE Content SET type='text' WHERE contentID = $ContentID");
      //Create new entry in text to lorem ipsum it up!
      executeSQL("INSERT INTO Text(contentID,content) VALUES($ContentID,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')");
      header("Refresh:0");
    }
  }else if($Type == "img"){
     //Get all the images in the contentBox
    $ImageFields = executeSQL("SELECT width,height,alt,url FROM Image WHERE contentID = $ContentID LIMIT 1");

    foreach ($ImageFields as $key => $value) {
      echo "<img class='$Type' src='$value[3]'>";
    }

    if(count($ImageFields) == 0){
      executeSQL("INSERT INTO Image(contentID,url) VALUES($ContentID, '/images/350x150.png')");
      echo "<img class='$Type' src='/images/350x150.png'>";
    }
  }else{
    echo "<p>DUD</p>";
    executeSQL("UPDATE Content SET type = 'text' WHERE contentID = $ContentID");
  }
  echo"</div>";
}

echo "</div>";
 ?>
