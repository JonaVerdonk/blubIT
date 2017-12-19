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
        if ($_SESSION['role'] !== 'x') {
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
          });

          function newSubPage(){
            if($("#Message").length == 0){
              $("body").append("<div id='Message'><div id='Message-header'>Subpage creatie</div><div id='Message-body'>Er zal een subpage worden gemaakt, hierbij is bevestiging nodig</div><div id='Message-buttons'><div id='Message-buttons-bevestig'>Bevestig</div><div id='Message-buttons-cancel'>cancel</div></div></div>");
            }
          }

          function LoadContent(selected){
            var startTime = new Date().getTime(); //Track time, it is used for calculating ajax delay

            $.ajax({
              url: "/php/CMS/LoadContent.php",
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
                    $("#PageContentList-" + data[i][2]).append("<p>" + data[i][0] + "</p>");
                  }

                  //close contentbox
                  $(".PageContentList").append("</div>");
                }

                //Add stats of ajax call
                var requestTime = new Date().getTime() - startTime; //Get new time and take begintime.
                $(".PageContentList").append("<p> The ajax request delay: " + requestTime + "ms</p>");
              }
            });
          }
        </script>

        <select class="File" name="" onchange="LoadFile()">
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
