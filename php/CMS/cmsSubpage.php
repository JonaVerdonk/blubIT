<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsSubpage.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        include_once("/scripts/databaseConnection.php");
        if ($_SESSION['role'] == 'r') {
            header("Location: /php/redirect.php");
        }
        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
        </script>
        <script>
          $(document).ready(function(){
            var startTime = new Date().getTime(); //Track time, it is used for calculating ajax delay
            //get full list of all images
            $.ajax({
              url: "Commands/getImages.php",
              type: "POST",
              success: function(json, status){
                data = $.parseJSON(json);
                window.Images = data;
                //folder== array
                //Add stats of ajax call
                var requestTime = new Date().getTime() - startTime; //Get new time and take begintime.
                $("body").append("<p> The ajax request for images delay: " + requestTime + "ms</p>");
              }
            });
          });
          function LoadFile(){
            //Get list of all editable items on the page
            //Input url => all editable items
            //Current logic
            //Send url to database, match every conent box that correspons with that url, This is gained by getting it from content
            //every content box
            var selected = $(".File").val();
            console.log(selected);
            switch(selected){
              case "NewSubpag": newSubPage(); break;
              default: LoadContent(selected); break;
            }
          }

          //EVENT LISTENERS
          $(document).on("click", "#Message-buttons-cancel", function(){
            var firstOption = $(".File option").first().val();
            $(".File").val(firstOption);
            $("#Message").remove();
          }).on("click",".PageContentList-edit",function(){
            var images = $(this).siblings("img");
            if(images.length != 0){
                //Image type

              //add buttons
              $(this).after("<div class='PageContentList-button'><div class='PageContentList-button-browse'>Browse</div><div class='PageContentList-button-discard'>Discard changes</div><div class='PageContentList-button-save'>Save changes</div></div>");

            }else{
              //Text type

              //add buttons
              $(this).after("<div class='PageContentList-button' id='PageContentList-button-top'><div class='PageContentList-button-discard' id='PageContentList-button-discard-top'>Discard changes</div><div class='PageContentList-button-save' id='PageContentList-button-save-top'>Save changes</div></div>");
              //Change the p to a textarea
              $(this).siblings(".PageContentList-text").replaceWith($("<textarea class='PageContentList-text'>" + $(this).siblings(".PageContentList-text").html() + '</textarea>'));
            }
            $(this).remove();
          }).on("click","#PageContentList-button-discard-top", function(){
            console.log($(this).parents("[id^=PageContentList-]"));
            $(this).parents("[id^=PageContentList-]").children(".PageContentList-text").replaceWith($("<p class='PageContentList-text'>" + $(this).parents("[id^=PageContentList-]").children(".PageContentList-text").html() + '</p>'));

            //Edit image/text
            $(this).parents("[id^=PageContentList-]").append("<div class='PageContentList-edit'>Edit</div>");

            //elliminate the target
            $(this).parent().remove();
          }).on("click", "#PageContentList-button-save-top, .PageContentList-button-save", function(){
            console.log("button has been pressed");
            //Gather info and send to server
            var newString = $(this).parent("[id^=PageContentList-]").parent("[id^=PageContentList-]").children(".PageContentList-text").val();

            var ContentID = $(this).parent("[id^=PageContentList-]").parent("[id^=PageContentList-]").attr("id").split("-")[1];
            if($(this).attr("id") == "PageContentList-button-save-top"){
              var Type = "text";
            }else{
              var Type = "img";
            }

            $.ajax({
              url: "Commands/UpdateContent.php",
              type: "POST",
              data: {"newString": newString, "ContentID": ContentID, "type": Type},
              success: function(json, status){
                data = $.parseJSON(json);
                console.log(data);
              }
            });
          }).on("click",".PageContentList-button-browse", function(){
            //draw the modal
            // String of all images window.Images
            var ImagesIndex = Object.keys(window.Images);

            for(value in window.Images){
              if(Array.isArray(window.Images[value])){
                console.log(value);
              }else{
                console.log(window.Images[value]);
              }
            }
            console.log(Images);
            //for(var i = 0; len = window.Images.length; i < len; i++){
            //  console.log(window.Images.keys(myArray).length);
          //  }
            //
          });

          //Loading and creation
          function newSubPage(){
            if($("#Message").length == 0){
              $("body").append("<div id='Message'><div id='Message-header'>Subpage creatie</div><div id='Message-body'>Er zal een subpage worden gemaakt, hierbij is bevestiging nodig</div><div id='Message-buttons'><div id='Message-buttons-bevestig' onclick='CreateNewSubPage()'>Bevestig</div><div id='Message-buttons-cancel'>cancel</div></div></div>");
            }
          }

          function CreateNewSubPage(){
            $.ajax({
              url: "Commands/createSub.php",
              type: "POST",
              success: function(json, status){
                data = $.parseJSON(json);
                console.log(data);
                console.log("request recieved");
              }
            });
          }

          function LoadContent(selected){
            var startTime = new Date().getTime(); //Track time, it is used for calculating ajax delay

            $.ajax({
              url: "Commands/LoadContent.php",
              type: "POST",
              data: {"url":selected},
              success: function(json, status){
                data = $.parseJSON(json);
                //data now contains an array of textfields and images
                //output format: Url/content, type, contentID

                //clear old contents
                $(".PageContentList").empty();

                //Add all the Contentboxes
                for (var i = 0; i < data.length; i++) {
                  //create a seperate box for each element on page
                  $(".PageContentList").append("<div id='PageContentList-" + data[i][2] + "'>");

                  //Add contents
                  $("#PageContentList-" + data[i][2]).append("<h2>" + data[i][2] + "</h2>");
                  if(data[i][1] == "img"){
                    $("#PageContentList-" + data[i][2]).append("<img src='" + data[i][0] + "'>");
                    $("#PageContentList-" + data[i][2]).append("<p class='PageContentList-img-url'>" + data[i][0] + "</p>");
                  }else{
                    $("#PageContentList-" + data[i][2]).append("<p class='PageContentList-text'>" + data[i][0] + "</p>");
                  }

                  //Edit image/text
                  $("#PageContentList-" + data[i][2]).append("<div class='PageContentList-edit'>Edit</div>");

                  //close contentbox
                  $(".PageContentList").append("</div>");
                }

                //create button to add contents
                $(".PageContentList").append("<div id='PageContentList-newContent'>Create new contentbox</div>");

                //Add stats of ajax call
                var requestTime = new Date().getTime() - startTime; //Get new time and take begintime.
                $(".PageContentList").append("<p> The ajax request delay: " + requestTime + "ms</p>");
              }
            });
          }
        </script>

        <select class="File" name="" onchange="LoadFile()">
        <option value="" disabled selected>Select the subpage</option>
        <!-- Make dropdown -->
        <?php
        //Get all known subpages
        $Subpages = scandir("../subpages");
        $Subpages = array_diff($Subpages, array('..', '.'));

        //loop through all known pages
        foreach ($Subpages as $index => $Record) {
          //for each record print as option
          echo "<option value='" . $Record . "'>" . $Record . "</option>";
        }
        ?>
        <option value='NewSubpag'>new subpage</option>
        </select>

        <div class="PageContentList"></div>
        <?php include("/scripts/footer.php"); ?>
    </body>
</html>
