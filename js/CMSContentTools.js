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

  function stripHTML(html){
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
  }

  window.editmode = false; //track if in edit mode
  window.cmsMenu = false; //track if menu is up or down
  window.editObj = null; //get id of currently editing obj
  window.MSGtype = null; //To store type of msg

  window.Text = null; //Hold the old text
  /* window.MSGtype list */
  // null = not selected
  // 1 = add contentbox
  // 2 = remove contentbox
  // 3 = confirm text change

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
    }else if(window.MSGtype == 3){
      var NewText = stripHTML($("textarea").val());
      var contentid = $("textarea").attr('class').split(" ")[1];
      var fullClass = $("textarea").attr('class');

      $("textarea").replaceWith("<p class = '"+ fullClass +"'>" + $("textarea").val() + "</p>");

      SQL_Ajax("UPDATE Text SET content = '" + NewText + "' WHERE contentID = " + contentid + "");

      $("#CMSToolbar-Message-buttons").remove();
      window.MSGtype = null;
    }
  }).on("click", "#CMSToolbar-Message-buttons-cancel", function(){
    if(window.MSGtype == 3){
      console.log(window.Text + $("textarea").val());
      $("textarea").val(window.Text);
      console.log(window.Text + $("textarea").val());
      $("textarea").replaceWith("<p>" + $("textarea").val() + "</p>");
      $("#CMSToolbar-Message-buttons").remove();
      window.MSGtype = null;
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
      $(this).children("p").after("<div id='CMSToolbar-Message-buttons' style='color: white;text-shadow: 0.5px 1px #7622ffb8;text-align: center;font-size: 20px;font-family: 'Quicksand', sans-serif;line-height: 40px;'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");

      $(this).children("p").replaceWith("<textarea class='" + this.className + "' style='width: 100%;'>" + $(this).children("p").text() + "</textarea>");

      window.MSGtype = 3;
      window.Text = $(this).text();
      window.Text = window.Text.replace('ConfirmCancel', '');
      }
    }

    //create msg
    if(window.MSGtype == 2 && window.editObj == null){
      window.editObj = this;
      $("#CMSToolbar-Message-body").after("<div id='CMSToolbar-Message-buttons'><div id='CMSToolbar-Message-buttons-confirm'>Confirm</div><div id='CMSToolbar-Message-buttons-cancel'>Cancel</div></div>");
    }
  });
});
