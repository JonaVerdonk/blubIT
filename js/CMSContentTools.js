$(document).ready(function(){
  //initialize the modalimg
  initModalIMG();

  //Function to parse quarrries
  function SQL_Ajax(SQLsting, Specialmode = 0){
    $.ajax({
        url: "/scripts/executeQuery.php",
        type: "POST",
        data: {"sql": SQLsting},
        success: function(json, status) {
            data = $.parseJSON(json);
            originalLength = data.length;
        }
    });
  }
  //Function to easyly clear the editobj and background
  function cleareditobj(){
    $(window.editObj).css({"border":"", "background":""});
    window.editObj = null;
  }
  //Function removes <script> and <style> from input
  function stripHTML(html){
   //take string and remove <script> and <style>
   // regex /.../ what to search after are modifiers in this case: case-insensitive(i) and global(g)(all not only first)
   return html.replace(/<script>|<style>/ig,"");
  }
  //Function when called makes sure nothing is selected and is put to start
  function deselectContent(ChangeMenu = true){
    //Deselect selection

    //remove background from edit mode
    $("#CMSToolbar-Body-button-edit").css("background-color","");
    //Show to correct items
    if(ChangeMenu){
      $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideUp(); //Gone
      $("#CMSToolbar-Body-button-addcont, #CMSToolbar-Body-button-remcont").slideDown(); //Now shown
    }
    //Remove the message if exist
    $("#CMSToolbar-Message").remove();

    //Cancel changes
      //Change the type back
      if($(window.editObj).children("textarea").length != 0){
        //its a text area
        if(window.Type != $(window.editObj).children("textarea").prop("className")){
          $(window.editObj).children("textarea").replaceWith("<img src='/images/350x150.png' class='img'>");
        }
      }else{
        //its a img area
        if(window.Type != $(window.editObj).children("img").prop("className")){
          $(window.editObj).children("img").replaceWith("<textarea class='text'>" + window.Text + "</textarea>");
        }
      }

      //Reset back
    if($(window.editObj).children("textarea").length != 0){
      //Set textareas in the document to what global variable winow.text is(latest original text)
      $("textarea").val(window.Text);
      //Change the tags to p and set the innerhtml to the value of textarea
      $("textarea").replaceWith("<p class='" + window.Type + "'>" + window.Text + "</p>");
    }else{
      //set src back
      $(window.editObj).children("img").attr("src",window.Src);
    }

    //Remove the buttons
    $("#CMSToolbar-Message-buttons").remove();
    //null the msgtype (will be reset later if needed)
    window.MSGtype = null;
    //set the editobject to null
    cleareditobj();
    //Now not anymore in edit mode
    window.editmode = null;
    //clear text
    window.Text = null;
    //clear the type
    window.Type = null;
    //clear the Src
    window.Src = null;
  }

  //Declare and initialize the global variables
  window.editmode = false; //track if in edit mode
  window.cmsMenu = false; //track if menu is up or down
  window.editObj = null; //get id of currently editing obj
  window.MSGtype = null; //To store type of msg

  window.Text = null; //Hold the old text
  window.Type = null; //hold the original type
  window.Src = null; //hold the original src

  /* window.MSGtype list */
  // null = not selected
  // 1 = add contentbox
  // 2 = remove contentbox
  // 3 = confirm text change

  ////////////////
  //EVENT LISTENERS

  //Auto remove editmode items
  $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideUp();
  $(document).on("click","#CMSToolbar-Header",function(){
    window.cmsMenu = !window.cmsMenu; //Inverse the variable
    if(window.cmsMenu){
      $(".CMSToolbar-Body-item").slideUp();

      $("#CMSToolbar-Message").remove();
      deselectContent(false);

      window.editmode = false;
      $("#CMSToolbar-Body-button-edit").css("background-color","");
    }else{
      $(".CMSToolbar-Body-item").slideDown();
      if(!window.editmode){
        $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideUp();
      }else{
        $("#CMSToolbar-Body-button-addcont, #CMSToolbar-Body-button-remcont").slideUp();
      }
    }
  }).on("click","#CMSToolbar-Body-button-edit",function(){
    window.editmode = !window.editmode;
    if(window.editmode){
      //Remove all previous messages
      $("#CMSToolbar-Message").remove();

      //Now editing
      $(this).css("background-color","#ff2d12B2");
      $("#CMSToolbar-Body-button-addcont, #CMSToolbar-Body-button-remcont").slideUp();
      $("#CMSToolbar").after("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>ATTENTIE</div><div id='CMSToolbar-Message-body'>selecteer de element die aangepast moet worden.</div></div>");
    }else{
      //cancel
      deselectContent();
    }
  }).on("click","#CMSToolbar-Body-button-addcont",function(){
    if($('#CMSToolbar-Message').length == 0){ //check if there are no Messages
      $("#CMSToolbar").append("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>CONFIRMATIE</div><div id='CMSToolbar-Message-body'>Er zal een nieuwe contentbox aangemaakt worden, kan U dat bevestigen?</div><div id='CMSToolbar-Message-buttons'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div></div>");
      window.MSGtype = 1;
    }
  }).on("click","#CMSToolbar-Body-button-remcont",function(){
    if($('#CMSToolbar-Message').length == 0){ //check if there are no Messages
      $("#CMSToolbar").append("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>ATTENTIE</div><div id='CMSToolbar-Message-body'>selecteer de element die verwijderd moet worden. LETOP: dit is onherkeerbaar!</div></div>");
      window.MSGtype = 2;
    }
  }).on("click", "#CMSToolbar-Message-buttons-confirm", function(){
      /* Behavior depends of type of message */

      if(window.MSGtype == 1){
      //Sql string
      var SQLsting = "INSERT INTO Content(url, position) VALUES(" + url + ", '1,3,1,3');";

      // Insert new content box
      SQL_Ajax(SQLsting);

      //EXECUTE INSERT SQL (LOG)
      var msg = "On " + url + " a contentbox was added.";
      SQL_Ajax("INSERT INTO Log(user, message) values(" + userID + ",'" + msg + "')");

      //Reload page
      location.reload();
    }else if(window.MSGtype == 2){
      var contentID = $(window.editObj).attr("class").split(" ")[1];
      //Sql string
      var SQLsting = "UPDATE Content SET url = '' WHERE contentID = '" + contentID + "';";

      // Update the url
      SQL_Ajax(SQLsting);

      //EXECUTE INSERT SQL (LOG)
      var msg = "On " + url + " a contentbox was removed having an id of " + contentID + ".";
      SQL_Ajax("INSERT INTO Log(user, message) values(" + userID + ",'" + msg + "')");

      //Reload page
      location.reload();
    }else if(window.MSGtype == 3){
      if($(window.editObj).children("textarea").length != 0){
        //variables
        var NewText = stripHTML($("textarea").val());
        var contentid = $("textarea").parent().attr('class').split(" ")[1];
        var Type = $("textarea").attr('class');

        //Check if imagefield is now text
        if(window.Type != $(window.editObj).children("textarea").prop("className")){
          //Update type to text
          SQL_Ajax("UPDATE Content SET type = 'text' WHERE contentID = " + contentid);
          //The type is now text
          window.Type = "text";
        }
        //Replace to p tag
        $("textarea").replaceWith("<p class = '"+ Type +"'>" + NewText + "</p>");
        //Update in db
        SQL_Ajax("UPDATE Text SET content = '" + NewText + "' WHERE contentID = " + contentid + "");
      }else{
        var newURL = stripHTML($(window.editObj).children("img").attr("src"));
        var contentid = $(window.editObj).attr('class').split(" ")[1];

        //Check if imagefield is now text
        if(window.Type != $(window.editObj).children("img").prop("className")){
          //Update type to text
          SQL_Ajax("UPDATE Content SET type = 'img' WHERE contentID = " + contentid);
          //The type is now img
          window.Type = "img";
        }
        
        //if record is found update else insert into
        $.ajax({
            url: "/scripts/executeQuery.php",
            type: "POST",
            data: {"sql": "SELECT * FROM Image WHERE contentID = " + contentid},
            success: function(json, status) {
                data = $.parseJSON(json);
                if(data.length == 0){ //No record
                  //Create record
                  SQL_Ajax("INSERT INTO Image(contentID, url) VALUES(" + contentid + ",'" + newURL + "')");
                }else{ //record found
                  //update record
                  SQL_Ajax("UPDATE Image SET url = '" + newURL + "' WHERE contentID = " + contentid);
                }
            }
        });

        //set the src to current url
        window.Src = newURL;
      }
      //always do this
      $("#CMSToolbar-Message-buttons").remove();
      window.MSGtype = null;

      //Clear edit mode etc
      deselectContent();
    }
  }).on("click", "#CMSToolbar-Message-buttons-cancel", function(){
    if(window.MSGtype == 3){
      deselectContent();
    }else{
      window.MSGtype = null;
      $("#CMSToolbar-Message").remove();
    }
  }).on("click",".content-body",function(){
    //Select The box
    if(window.editObj == null && window.editmode){
       //Get id of contentnox
      window.editObj = this;
       //remove message
      $("#CMSToolbar-Message").remove();
       //Add styling to show it is selected
      $(this).css({"border":"2px solid white", "background":"linear-gradient(45deg,white,lightgray"});

       //Add edittools to menu
      $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideDown();


       //Edit text
      var parentID = $(this).prop('className').split(" ")[1];
      var editobjID = $(window.editObj).prop('className').split(" ")[1];

      if(parentID == editobjID){
        //Change the menu item name
        $("#CMSToolbar-Body-button-add").text("Verander naar" + ($(this).children("p").prop('className') == "text"? " image" : " text"));
        if($(this).children("p").length != 0){ //It is a text
           //Create the buttons
          $(this).children("p").after("<div id='CMSToolbar-Message-buttons' style='color: white;text-shadow: 0.5px 1px #7622ffb8;text-align: center;font-size: 20px;font-family: 'Quicksand', sans-serif;line-height: 40px;'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");
           //change the p tags to textarea
          $(this).children("p").replaceWith("<textarea class='" + $(this).children("p").prop('className')  + "'>" + $(this).children("p").text() + "</textarea>");
           //set the original type to text
          window.Type = "text";
           //set the original text to current text
          window.Text = $(this).text();
          window.Text = window.Text.replace('ConfirmCancel', '');
        }else{ //its a img
           //Create the buttons
          $(this).children("img").after("<div id='CMSToolbar-Message-buttons' style='color: white;text-shadow: 0.5px 1px #7622ffb8;text-align: center;font-size: 20px;font-family: 'Quicksand', sans-serif;line-height: 40px;'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");
           //Set the original type to img
          window.Type = "img";
          window.Src = $(this).children("img").attr("src");
        }

        //Set type to 3 and get the text however remove ""ConfirmCancel"" and set the type.
        window.MSGtype = 3;
      }
    }

    //create msg
    if(window.MSGtype == 2 && window.editObj == null){
      window.editObj = this;
      $("#CMSToolbar-Message-body").after("<div id='CMSToolbar-Message-buttons'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");
    }
  }).on("click","#CMSToolbar-Body-button-add",function(){ //Add is change between img and p
    if($("textarea").length != 0){
      $("textarea").replaceWith("<img src='/images/350x150.png' class='img'>");
      $("#CMSToolbar-Body-button-add").text("Verander naar text");
    }else{
      $(window.editObj).children("img").replaceWith("<textarea class='text'>" + window.Text + "</textarea>");
      $("#CMSToolbar-Body-button-add").text("Verander naar image");
    }
  }).on("dblclick", "img", function(){
    //check if in edit mode
    if(window.editmode){
      //check if correct img is pressed
      //Edit text
     var clickedID = $(this).parent().prop('className').split(" ")[1];
     var editobjID = $(window.editObj).prop('className').split(" ")[1];

     if(clickedID == editobjID){
      //Call modal and it will set it for us
      DrawModalIMG($(this));
    }
  }
  });
});
