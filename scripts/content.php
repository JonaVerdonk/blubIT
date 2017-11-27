<?php
include("databaseConnection.php.php");
$contentAdmin = true;

$array = array(1,1,1,1,1,1,11,1,2,3,5,6,3,4,5,6,7,8,3,3,121,1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='css/content.css'> <div id='content'>";
foreach ($array as $index => $ContentID) {
  echo "<div class='content-body'>";
  $textFields = executeSQL("SELECT content FROM Text WHERE contentID = $ContentID");
  foreach ($textFields as $key => $value) {
    echo "<p>" . $value[0] . "</p>";
  }
  echo"</div>";
}
echo "</div>";

 ?>
