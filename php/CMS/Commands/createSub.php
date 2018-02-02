<?php
//Allow usage of sessions
session_start();

//User needs to be logged in and authorized
if ($_SESSION['role'] == 'r' || $_SESSION['logged_in'] != 1) {
    header("Location: ../../redirect.php");
}
//create file

//get unique number
do{
  $randomNum = rand(1,10000);
}while(file_exists("../../subpages/" . $randomNum . ".php"));


$randomNum = rand(1,10000);
//get url
$my_file = "../../subpages/" . $randomNum . ".php";

//create file
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

//copy from template
copy("../../../Templates/subpage.php",$my_file);
//close file
fclose($handle);

//Create entry in the database
include_once("../../../scripts/databaseConnection.php");
$url = $randomNum . ".php";
executeSQL("INSERT INTO Subpages(url, title) VALUES('$url', '$randomNum')");

//Give the random number back
echo json_encode($randomNum);
 ?>
