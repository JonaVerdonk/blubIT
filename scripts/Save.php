<?php


if(isset($_GET['save'])){

    $name = $_GET['connector'];

    print"<input class='text' type='text' value='";
    foreach ($name as $connect){
       print $connect;
       print ". ";
   }
   print"' placeholder='Connector type'>";
}

?>
