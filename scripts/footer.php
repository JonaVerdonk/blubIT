<link rel="stylesheet" href="/css/footer.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<?php

require("GlobalFunctions.php");

/////////////////////////////////////////////////////
//HTML printing//////////////////////////////////////
////////////////////////////////////////////////////
echo"
<div class='clear'></div>
<footer>";
// echo "<div id='footer-reference'>";
//   printRefferences();
// echo "</div>";
  echo "<div id='footer-bottom'>
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
