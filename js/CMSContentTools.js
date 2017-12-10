$(document).ready(function(){
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

  function cleareditobj(){
    $(window.editObj).css({"border":"", "background":""});
    window.editObj = null;
  }

  window.editmode = false; //track if in edit mode
  window.cmsMenu = false; //track if menu is up or down
  window.editObj = null; //get id of currently editing obj
  window.MSGtype = null; //To store type of msg

  /* window.MSGtype list */
  // null = not selected
  // 1 = add contentbox
  // 2 = remove contentbox

  //Auto remove editmode items
  $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideUp();
  $(document).on("click","#CMSToolbar-Header",function(){
    window.cmsMenu = !window.cmsMenu;
    if(window.cmsMenu){
      $(".CMSToolbar-Body-item").slideUp();

      $("#CMSToolbar-Message").remove();
      cleareditobj();

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
      $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideDown();
      $("#CMSToolbar-Body-button-addcont, #CMSToolbar-Body-button-remcont").slideUp();
      $("#CMSToolbar").append("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>ATTENTIE</div><div id='CMSToolbar-Message-body'>selecteer de element die aangepast moet worden.</div></div>");
    }else{
      $(this).css("background-color","");
      $("#CMSToolbar-Body-button-add, #CMSToolbar-Body-button-remove, #CMSToolbar-Body-button-move").slideUp();
      $("#CMSToolbar-Body-button-addcont, #CMSToolbar-Body-button-remcont").slideDown();
      $("#CMSToolbar-Message").remove();
      cleareditobj();
    }
  }).on("click","#CMSToolbar-Body-button-addcont",function(){
    if($('#CMSToolbar-Message').length == 0){ //No Message
      $("#CMSToolbar").append("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>CONFIRMATIE</div><div id='CMSToolbar-Message-body'>Er zal een nieuwe contentbox aangemaakt worden, kan U dat bevestigen?</div><div id='CMSToolbar-Message-buttons'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div></div>");
      window.MSGtype = 1;
    }
  }).on("click","#CMSToolbar-Body-button-remcont",function(){
    if($('#CMSToolbar-Message').length == 0){ //No Message
      $("#CMSToolbar").append("<div id='CMSToolbar-Message'><div id='CMSToolbar-Message-header'>ATTENTIE</div><div id='CMSToolbar-Message-body'>selecteer de element die verwijderd moet worden. LETOP: dit is onherkeerbaar!</div></div>");
      window.MSGtype = 2;
    }
  }).on("click", "#CMSToolbar-Message-buttons-confirm", function(){
      /* Behavior depents of type of message */

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
    }
  }).on("click", "#CMSToolbar-Message-buttons-cancel", function(){
    window.MSGtype = null;
    $("#CMSToolbar-Message").remove();
  }).on("click",".content-body",function(){
    if(window.editObj == null && window.editmode){
      //Get id of contentnox
      window.editObj = this;
      //remove message
      $("#CMSToolbar-Message").remove();
      //Add styling to show it is selected
      $(this).css({"border":"2px solid white", "background":"linear-gradient(45deg,white,lightgray"});
    }
    if(window.MSGtype == 2 && window.editObj == null){
      window.editObj = this;
      $("#CMSToolbar-Message-body").after("<div id='CMSToolbar-Message-buttons'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");
    }
  });
});
