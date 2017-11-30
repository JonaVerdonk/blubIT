<link rel="stylesheet" href="/css/footer.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       footer();
   }
}).resize(function(){
  if(Math.round($("body").height()+100) == $(window).height()){
    footer();
  }
  $("#content").css("padding-top", $("header").height());
}).ready(function(){
  $("#footer-bottom").addClass("show");
  $("#footer-bottom").show();
  $("#content").css("padding-top", $("header").height());
  footer();
});

function footer(){
      var scroll = $(window).scrollTop();
      if(scroll>20 || Math.round($("body").height()+100) == $(window).height()){
          $("#footer-bottom").fadeIn("slow").addClass("show");
      }else{
          $("#footer-bottom").fadeOut("slow").removeClass("show");
      }

      clearTimeout($.data(this, 'scrollTimer'));
      $.data(this, 'scrollTimer', setTimeout(function() {
        //Math.floor used because it added .800048828125 to first part for some reason
          if ($('#footer-bottom').is(':hover') || (Math.round($("body").height()+100) == $(window).height()) || Math.floor($(window).scrollTop() + $(window).height() + 60) >= $(document).height()) {
          footer();
      }  else{
        $("#footer-bottom").fadeOut("slow");
      }
  }, 2000));
  }
$(window).scroll(function(event) {
  footer();
});
</script>
<?php

require("GlobalFunctions.php");

/////////////////////////////////////////////////////
//HTML printing//////////////////////////////////////
////////////////////////////////////////////////////
echo"
<div class='clear'></div>
<footer>
<div id='footer-reference'>";
  printRefferences();
echo "</div>
  <div id='footer-bottom'>
    <div id='footer-icon'>
      <div class='footer-icon-container'>
        <span>&#9749;</span>
      </div>
    <div class='footer-icon-container'>
      <span>&#x2709</span>

    </div>
    <div class='footer-icon-container'>
      <span>&#x2706</span>
    </div>
  </div>
  <div id='footer-contact'>";

    //Get Bedrijfnaam, telnummer,
    $info = array("bedrijfnaam" => "Meijer Glasvezeltechniek", "telnummer" => "+31 (0)6 11644811");

    echo "<span>" . $info['bedrijfnaam'] . " |  <a href='tel:" . $info['telnummer'] . "'>" . $info['telnummer'] . "</a></span>
    </div>
  </div>
</footer>
";
?>
