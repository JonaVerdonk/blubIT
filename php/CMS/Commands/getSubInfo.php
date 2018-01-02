<?php
//Load in the database library
include_once("../../../scripts/databaseConnection.php");

//Get the subpage url
$url = filter_input(INPUT_POST, "Page", FILTER_SANITIZE_SPECIAL_CHARS);

//execute QUARRRRY
$PagTitle = executeSQL("SELECT title FROM Subpages WHERE url = '$url'",2);
$NumElem = executeSQL("SELECT COUNT(url) FROM Content WHERE url = '/php/subpages/$url'",2);

$result = array("Title" => $PagTitle[0][0], "NumElem" => $NumElem[0][0]);
//relay data back to client
echo json_encode($result);
 ?>
