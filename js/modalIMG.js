//Functions
function initModalIMG(){
  $.ajax({
    url: "/php/CMS/Commands/getImages.php",
    type: "POST",
    success: function(json, status){
      window.imagesList = $.parseJSON(json);
    }
  });
}

function DrawModalIMG(callingIMG){
  //check if no other boxes exist
  if($("#MODALIMG-background").length != 0){
    return;
  }

  //Draw
  $("body").append("<div id='MODALIMG-background'><div id='MODALIMG-body'><div id='MODALIMG-body-list'></div><img alt='bestandtype wordt niet herkend. herkende bestanden: PNG,JPG,JPEG,GIF' src='/images/350x150.png' id='MODALIMG-body-preview'><div id='MODALIMG-body-buttons'><div id='MODALIMG-body-buttons-cancel'>Annuleren</div><div id='MODALIMG-body-buttons-confirm'>Gebruik foto</div></div></div></div>");

  //get all files and folders of root and apend to list
  for (var i = 0; i < window.imagesList.length; i++) {
    $("#MODALIMG-body-list").append("<span>" + window.imagesList[i] + "</span>");
  }
  //Set variables
  selectedImg = null;

  //Set event listnets
  $(document).on("mouseover","#MODALIMG-body-list span", function(){
    //on mouseover set src to hovering url
    $("#MODALIMG-body-preview").attr("src", $(this).text());
  }).on("mouseleave","#MODALIMG-body-list", function(){
    //if you leave mouse set (if already set) to the selected item
    if(selectedImg != null){
      $("#MODALIMG-body-preview").attr("src", selectedImg.text());
    }
  }).on("click", "#MODALIMG-body-list span", function(){
    //Clear any other selected
    if(selectedImg != null){
      selectedImg.css({"background-color":"", "border-top": "", "border-bottom": ""});
    }
    //Set the styling
    $(this).css({"background-color":"#2e6ca5", "border-top": "3px double white", "border-bottom": "3px double white"});
    //Get the selected
    selectedImg = $(this);
  }).on("click", "#MODALIMG-body-buttons-cancel", function(){
    $("#MODALIMG-background").remove(); //remove modal
    return; //EXIT out of function to stop event listeners
  }).on("click", "#MODALIMG-body-buttons-confirm", function(){
    selectedImg = selectedImg.text(); //get url of selected
    callingIMG.attr("src", selectedImg); //Set the src of calling object
    $("#MODALIMG-background").remove(); //remove modal
    return; //EXIT out of function to stop event listeners
  });
}
