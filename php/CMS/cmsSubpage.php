<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Subpagina's</title>
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
          //EVENT LISTENERS
          $(document).on("click","#Message-buttons-cancel", function(){
            $(this).parent().parent().remove();
          }).on("click","#File-buttons-Discard", function(){
            $("#File-buttons-title").val(window.OriginalFields["Title"]);
            $("#File-buttons-docnamin").val($(".File").val().replace('.php',''));
            $("#File-buttons-NumElem").val(window.OriginalFields["NumElem"]);
          }).on("click","#File-buttons-Save", function(){
            var inputField = new Array($("#File-buttons-title").val(),$("#File-buttons-docnamin").val(),$("#File-buttons-delpass").val());
            $.ajax({
               url: "Commands/SetSubInfo.php",
               type: "POST",
               data : {"Textfields":inputField, "ORGTextfields": window.OriginalFields},
               success: function(json, status){
                  data = $.parseJSON(json);
                  if(data == "DELFILE"){
                    location.reload();
                  }else if(data == "INVALID PASSWORD"){
                    alert(data);
                  }else{
                    alert("de subpagina is successvol veranderd");
                  }

                  //Change options text
                  var oldText = $(".File option:selected").text();
                  if(oldText.indexOf("[nieuw]") !== -1){
                    $(".File option:selected").text("[nieuw] " + inputField[1] + ".php");
                  }else{
                    $(".File option:selected").text(inputField[1] + ".php");
                  }

                  $("#File-buttons-gotoPag").children().attr("href","../subpages/" + inputField[1]);
               }
            });
          });

          //Functions
          function AlterFields(){
            $.ajax({
              url: "Commands/getSubInfo.php",
              type: "POST",
              data: {"Page":$(".File").val()},
              success: function(json, status){
                data = $.parseJSON(json);
                $("#File-buttons-title").val(data["Title"]);
                $("#File-buttons-docnamin").val($(".File").val().replace('.php',''));
                $("#File-buttons-NumElem").val(data["NumElem"]);
                window.OriginalFields = data;
                window.OriginalFields["docName"] = $(".File").val().replace('.php','');

                $("#File-buttons-gotoPag").children().attr("href","../subpages/" + $(".File").val());
              }
            });
          }

          //Loading and creation
          function OptionChange(){
            if($("#Message").length == 0 && $(".File").val() == "NewSubpag"){
              $("body").append("<div id='Message'><div id='Message-header'>Subpagina maken</div><div id='Message-body'>Er zal een subpage worden gemaakt, hierbij is bevestiging nodig</div><div id='Message-buttons'><div id='Message-buttons-bevestig' onclick='CreateNewSubPage()'>Bevestig</div><div id='Message-buttons-cancel'>cancel</div></div></div>");
            }else{
              //Create buttons if it does not exist else change them to pint to new subpage
              if($("#File-buttons").length == 0){
                //create buttons
                $(".PageContentList").append("<div id='File-buttons'><div id='File-buttons-gotoPag'><a>Ga naar de subpagina</a></div><div><div>Titel: </div><input id='File-buttons-title' placeholder='Idem als bestandnaam' title='Indien het veld leeg is zal dit de bestandnaam zonder \".php\" worden'></div><div><div>Document naam: </div><input id='File-buttons-docnamin'><div>.php</div></div><div><div>Aantal elementen: </div><input id='File-buttons-NumElem' readonly></div><div><div>Verwijder bestand: </div><input type='password' placeholder='voer wachtwoord in om de subpagina te verwijderen' style='font-size:20px' id='File-buttons-delpass'></div></div><div id='File-buttons-Lower'><div id='File-buttons-Save'>Save Changes</div><div id='File-buttons-Discard'>Revert Changes</div></div>");
                AlterFields();
              }else{
                //alter buttons
                AlterFields();
              }
            }
          }

          function CreateNewSubPage(){
            $.ajax({
              url: "Commands/createSub.php",
              type: "POST",
              success: function(json, status){
                data = $.parseJSON(json);
                $(".File").append("<option value='" + data + ".php'>[nieuw] " + data + ".php</option>").val(data + ".php");
                OptionChange();
                $("#Message").remove();
              }
            });
          }

        </script>

        <select class="File" name="" onchange='OptionChange()'>
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
        <?php include("../../scripts/footer.php"); ?>
    </body>
</html>
