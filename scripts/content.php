<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet"> <!--Font-->
<script type="text/javascript">
  $(document).ready(function(){
    ////////////////////
    ///JAVASCRIPT FUNCTIONS
    ////////////////////
    function replaceChar(string, loc, newChar){
      // Split string into an array
      var str = string.split("");

      // Replace char at index
      str[loc] = newChar;

      // Output new string
      return str.join("");
    }

    function getChar(string, loc){
      // Split string into an array
      var str = string.split("");

      // Replace char at index
      return str[loc];
    }

    function getGridValues(GridArea){
      //This function returns the 4 values no matter how long they area
      //Old system breaks downs if value is negative or bigger than 9 this should solve it
      //Sample gridArea: "1 / 1 / span 1 / span 6"
      //Sample gridArea: "76 / 1 / span 7 / span 12"
      var numbermode = false; //if true last char was number
      var numberindex = 0; //What number is currently being changed (Added)
      var numbers = [0,0,0,0]; //array is filled else undefined

      for(var i = 0; i < GridArea.length; i++){
        //Cycle through every character in string
        var charValue = getChar(GridArea, i); //Get char
        if(!isNaN(charValue)){ //Numeral or space
          if(/\S/.test(charValue)){ //numeral
            numbermode = true; //Still part of number
            numbers[numberindex] += charValue; //Add teh char
          }else if(numbermode){
            numbermode = false; //Space detected
            numbers[numberindex] = parseInt(numbers[numberindex]); //Make it into a int
            numberindex++; //new number

          }
        }
      }

      numbers[numberindex] = parseInt(numbers[numberindex]); //Make last value int because else it will be string
      return numbers; //return the array
      //Output array of 4 elements: y , x, height, width
      //Samples: output => 01,01,01,06 & 076,01,07,012
    }

    function SQL_Ajax(SQLsting){
      $.ajax({
          url: "/scripts/executeQuery.php",
          type: "POST",
          data: {"sql": SQLsting},
          success: function(json, status) {
              data = $.parseJSON(json);
              originalLength = data.length;
              return data;
          }
      });
    }
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

            for (var i = 0, len = data.length; i < len; i++) {
              var RAWposition = data[i][0];
              var position = RAWposition.split(",");

              var GridCol = position[0] + " / span " + position[1];
              var GridRow = position[2] + " / span " + position[3];

              $("." + data[i][1]).css({"grid-column" : GridCol , "grid-row" : GridRow});
            }
        }
    });

    $(document).on("dblclick", ".content-body", function() {
      if($('#cmsMoveTool-background').length == 0){ //Does a modal already exist
        //It needs to create one
        window.callObj = this;

         //Create most of modal
        $(this).append(<?php CreateModal(); ?>); //String too long needed php
         //Add the cancel and confirm butttons
        $("#cmsMoveTool-body").append("<div id='cmsMoveTool-body-buttons'><div id='cmsMoveTool-body-buttons-cancel'>Cancel</div><div id='cmsMoveTool-body-buttons-confirm'>Confirm changes</div></div>");
         //Add grid info to the modal
          //Get string
        window.gridArea = $(window.callObj).attr("style");
         //Get relevant info
        var gridvalues = getGridValues(window.gridArea); //Loc y, loc x, height, width

        window.OriginalGridArea = gridvalues[0] + " / " + gridvalues[1] + " / span " + gridvalues[2] +" / span " + gridvalues[3]; //Later used to see if changed and how much
          //Append info
        $("#cmsMoveTool-body-content-kolom-value").append(gridvalues[1]);
        $("#cmsMoveTool-body-content-rij-value").append(gridvalues[0]);
        $("#cmsMoveTool-body-content-breedte-value").append(gridvalues[3]);
        $("#cmsMoveTool-body-content-hoogte-value").append(gridvalues[2]);
        }
    }).on("click", "#cmsMoveTool-body-buttons-cancel, #cmsMoveTool-confirmation-cancel", function(){
      $(window.callObj).css("grid-area", window.OriginalGridArea);
      $("#cmsMoveTool-background").remove();
    }).on("click", "#cmsMoveTool-confirmation-confirm", function(){
      var gridvalues = getGridValues(window.gridArea);
      console.log(gridvalues);
      //Get relevant info
     var gridvaluesoriginal = getGridValues(window.OriginalGridArea); //Loc y, loc x, height, width

      var originalLocString = gridvaluesoriginal[1] + "," + gridvaluesoriginal[3] + "," + gridvaluesoriginal[0] + "," + gridvaluesoriginal[2];
      var locationString = gridvalues[1] + "," + gridvalues[3] + "," + gridvalues[0] + "," + gridvalues[2];//Use and format for database
      console.log(locationString);
      var ObjID = $(window.callObj).attr('class').split(' ')[1];
      //EXECUTE UPDATE SQL (content)
      SQL_Ajax("UPDATE Content SET position = '" + locationString + "' WHERE contentID = " + ObjID);
      //EXECUTE INSERT SQL (LOG)
      var msg = "On " + window.location.href + " a contentbox with id " + ObjID + " has been moved the element was on " + originalLocString + " now it is on " + locationString;
      SQL_Ajax("INSERT INTO Log(user, message) values(1,'" + msg + "')");
      //Remove all modals
      $("#cmsMoveTool-background").remove();

    }).on("click", "#cmsMoveTool-body-buttons-confirm", function(){
      $("#cmsMoveTool-body").hide();

       //Get relevant info
      var gridvaluesoriginal = getGridValues(window.OriginalGridArea); //Loc y, loc x, height, width
       //Get relevant info
      var gridvalues = getGridValues(window.gridArea); //Loc y, loc x, height, width
      var confirmationMSG = "Er wordt een onherkeerbaar process uitgevoerd, wilt U bevestigen dat de aanpassing permanent zijn en onherkeerbaar.";
      //Take in 9 values: Message, old gridvalues(4x), new gridvalues(4x)
      $("#cmsMoveTool-background").append("<div id='cmsMoveTool-confirmation'><div id='cmsMoveTool-confirmation-header'>Confirmation</div><div id='cmsMoveTool-confirmation-changes'><div id='cmsMoveTool-confirmation-kolom'><span>KOLOM</span><div id='cmsMoveTool-confirmation-kolom-old' class='cmsMoveTool-confirmation-old/new'>" + gridvaluesoriginal[1] + "</div><div id='cmsMoveTool-confirmation-kolom-pijl'>&#8595;</div><div id='cmsMoveTool-confirmation-kolom-new' class='cmsMoveTool-confirmation-old/new'>" + gridvalues[1] + "</div></div><div id='cmsMoveTool-confirmation-rij'><span>RIJ</span><div id='cmsMoveTool-confirmation-rij-old' class='cmsMoveTool-confirmation-old/new'>" + gridvaluesoriginal[0] + "</div><div id='cmsMoveTool-confirmation-rij-pijl'>&#8595;</div><div id='cmsMoveTool-confirmation-rij-new' class='cmsMoveTool-confirmation-old/new'>" + gridvalues[0] + "</div></div><div id='cmsMoveTool-confirmation-breedte'><span>BREEDTE</span><div id='cmsMoveTool-confirmation-breedte-old' class='cmsMoveTool-confirmation-old/new'>" + gridvaluesoriginal[3] + "</div><div id='cmsMoveTool-confirmation-breedte-pijl'>&#8595;</div><div id='cmsMoveTool-confirmation-breedte-new' class='cmsMoveTool-confirmation-old/new'>" + gridvalues[3] +  "</div></div><div id='cmsMoveTool-confirmation-hoogte'><span>HOOGTE</span><div id='cmsMoveTool-confirmation-hoogte-old' class='cmsMoveTool-confirmation-old/new'>" + gridvaluesoriginal[2] + "</div><div id='cmsMoveTool-confirmation-hoogte-pijl'>&#8595;</div><div id='cmsMoveTool-confirmation-hoogte-new' class='cmsMoveTool-confirmation-old/new'>" + gridvalues[2] + "</div></div></div><div id='cmsMoveTool-confirmation-msg'>" + confirmationMSG + "</div><div id='cmsMoveTool-confirmation-buttons'><div id='cmsMoveTool-confirmation-cancel'>Cancel</div><div id='cmsMoveTool-confirmation-confirm'>Confirm changes</div></div></div>");
      for (var i = 0; i < gridvalues.length; i++) {
        //id
        switch(i){
          case 1: var CurrentID = "cmsMoveTool-confirmation-kolom-new"; break;
          case 0: var CurrentID = "cmsMoveTool-confirmation-rij-new"; break;
          case 3: var CurrentID = "cmsMoveTool-confirmation-breedte-new"; break;
          case 2: var CurrentID = "cmsMoveTool-confirmation-hoogte-new"; break;
          default: console.log("Error: out of bounds (001)"); break;
        }
        //color
        if(gridvalues[i] == gridvaluesoriginal[i]){
          var color = "white";
        }else if(gridvalues[i] > gridvaluesoriginal[i]){
          var color = "#13f798";
        }else{
          var color = "#FF6854";
        }
        var type = CurrentID.split("-")[2];
        var change = Math.abs(gridvalues[i] - gridvaluesoriginal[i]);

        if(change == 0){
          var titleString = "Er was geen verandering";
        }else if(change == 1){
          var titleString = "De " + type + " is met " + change + " punt veranderd";
        }else{
          var titleString = "De " + type + " is met " + change + " punten veranderd";
        }

        $("#" + CurrentID).css("color",color);
        $("#" + CurrentID).attr("title",titleString);
      }

      // $("#cmsMoveTool-background").remove();
    }).on("click", ".CmsMoveTool-button", function(){
      //Change differend things depening on id
      switch(this.id){
        case "cmsMoveTool-body-content-clickers-moveup":          GridIndex = 0; change = -1; break;
        case "cmsMoveTool-body-content-clickers-movedown":        GridIndex = 0; change = 1; break;
        case "cmsMoveTool-body-content-clickers-moveleft":        GridIndex = 1; change = -1; break;
        case "cmsMoveTool-body-content-clickers-moveright":       GridIndex = 1; change = 1; break;
        case "cmsMoveTool-body-content-clickers-add-breedte":     GridIndex = 3; change = 1; break
        case "cmsMoveTool-body-content-clickers-remove-breedte":  GridIndex = 3; change = -1; break;
        case "cmsMoveTool-body-content-clickers-remove-hoogte":   GridIndex = 2; change = -1; break;
        case "cmsMoveTool-body-content-clickers-add-hoogte":      GridIndex = 2; change = 1; break;
        default: console.log("Error: invalid id (002)");                return;
      }

      var gridvalues = getGridValues(window.gridArea); //Loc y, loc x, height, width
      gridvalues[GridIndex] = gridvalues[GridIndex] + change;

      window.gridArea = gridvalues[0] + " / " + gridvalues[1] + " / span " + gridvalues[2] +" / span " + gridvalues[3];
      //execute new area
      $(window.callObj).css("grid-area", window.gridArea);

      //update values
      $("#cmsMoveTool-body-content-kolom-value").html(gridvalues[1]);
      $("#cmsMoveTool-body-content-rij-value").html(gridvalues[0]);
      $("#cmsMoveTool-body-content-breedte-value").html(gridvalues[3]);
      $("#cmsMoveTool-body-content-hoogte-value").html(gridvalues[2]);
    });
});
</script>
<?php

//////////////////////////////////
///////FUNCTIONS
///////////////////////////////////////////
function CreateModal(){
  echo "\"<div id='cmsMoveTool-background'><div id='cmsMoveTool-body'><div id='cmsMoveTool-body-content'><div id='cmsMoveTool-body-content-info'><div id='cmsMoveTool-body-content-kolom'><div id='cmsMoveTool-body-content-kolom-value'></div><div id='cmsMoveTool-body-content-kolom-text' title='De kolom het element staat'>kolom</div></div><div id='cmsMoveTool-body-content-rij'><div id='cmsMoveTool-body-content-rij-value'></div><div id='cmsMoveTool-body-content-rij-text' title='De rij het element staat'>Rij</div></div><div id='cmsMoveTool-body-content-breedte'><div id='cmsMoveTool-body-content-breedte-value'></div><div id='cmsMoveTool-body-content-breedte-text' title='de hoeveel kollomen die de element vult'>breedte</div></div><div id='cmsMoveTool-body-content-hoogte'><div id='cmsMoveTool-body-content-hoogte-value'></div><div id='cmsMoveTool-body-content-hoogte-text' title='De hoeveelheid rijen die de element vult'>Hoogte</div></div></div><div id='cmsMoveTool-body-content-clickers'><div id='cmsMoveTool-body-content-clickers-movement'><div id='cmsMoveTool-body-content-clickers-moveup' class='CmsMoveTool-button'>&#8593</div><div id='cmsMoveTool-body-content-clickers-movedown' class='CmsMoveTool-button'>&#8595</div><div id='cmsMoveTool-body-content-clickers-moveleft' class='CmsMoveTool-button'>&#8592;</div><div id='cmsMoveTool-body-content-clickers-moveright' class='CmsMoveTool-button'>&#8594</div></div><div id='cmsMoveTool-body-content-clickers-add-breedte' class='CmsMoveTool-button'>&#8594</div><div id='cmsMoveTool-body-content-clickers-add-hoogte' class='CmsMoveTool-button'>&#8594</div><div id='cmsMoveTool-body-content-clickers-remove-breedte' class='CmsMoveTool-button'>&#8592;</div><div id='cmsMoveTool-body-content-clickers-remove-hoogte' class='CmsMoveTool-button'>&#8592;</div></div></div></div></div>\"";
}
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
