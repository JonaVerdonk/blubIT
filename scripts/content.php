<script type="text/javascript">
  $(document).ready(function(){
    //positioning of objects
    //Loop
    //Get positioning EG. 3, 8, 2, 3 // <- Means 3 columns right that span 8 collumn and 2 rows down that span 3 down
    //

    $.ajax({
        url: "/scripts/executeQuery.php",
        type: "POST",
        data: {"sql": "SELECT position, contentID FROM Content;"},
        success: function(json, status) {

            data = $.parseJSON(json);
            originalLength = data.length;
            /*
                array(
                  [0] => array("position" => "3,8,2,3")
                  [1] => array("position" => "4,8,7,3")
                  [2] => array("position" => "5,8,8,3")
                  [3] => array("position" => "6,8,9,3")
                )

            */

            for (var i = 0, len = data.length; i < len; i++) {
              var RAWposition = data[i][0];
              var position = RAWposition.split(",");

              var GridCol = position[0] + " / span " + position[1];
              var GridRow = position[2] + " / span " + position[3];

              console.log("data[i][1]: " + data[i][1]);
              console.log("GridCol: " + GridCol);
              console.log("GridRow: " + GridRow);
              $("." + data[i][1]).css({"grid-column" : GridCol , "grid-row" : GridRow});
            }
        }
    });
  });
</script>
<?php
$contentAdmin = true;

//GET a list of all the contentboxes in the pages
  //GET URL
$url = $_SERVER['PHP_SELF'];
  // SET QUERRY
$query = "SELECT contentID FROM Content WHERE url = \"" . $url . "\"";
 // Execute Query
$array = executeSQL($query, 1);//Get list of content in page

echo "<link rel='stylesheet' type='text/css' href='css/content.css'> <div id='content'>"; //Add the styling
  //Cycle through the array
foreach($array as $indexMain => $Record){
    //Get Data inside the record
  $ContentID = $Record["contentID"];

    //Create the div
  echo "<div class='content-body $ContentID'>";
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
