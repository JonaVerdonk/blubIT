<?php
//Allow usage of sessions
session_start();

//Get all data and filter it
$args = array(
  "Textfields" => array(
    "filter" => FILTER_SANITIZE_SPECIAL_CHARS,
    "flags" => FILTER_REQUIRE_ARRAY
  ),
  "ORGTextfields" => array(
    "filter" => FILTER_SANITIZE_SPECIAL_CHARS,
    "flags" => FILTER_REQUIRE_ARRAY
   )
);

$subFullArray = filter_input_array(INPUT_POST, $args); //$subFullArray == $_POST
$subFullArray = $subFullArray["Textfields"] + $subFullArray["ORGTextfields"]; //$subFullArray is now the array

//{0: "6897", 1: "6897", 2: "", Title: "6897", NumElem: "0", docName: "6897"} ///SAMPLE INPUT
//$subFullArray is now set and ready to work

//Include connection library
include_once("../../../scripts/databaseConnection.php");

//changes => title only update in database , document name => change in subpages(url) and all contentboxes and document, password if correct delete document only

///////////////////////
//TITLE CHANGES
//////////////////////
if($subFullArray[0] != $subFullArray["Title"]){
  //Title has changed
  $sql = "UPDATE Subpages SET title = '$subFullArray[0]' WHERE url = '" . $subFullArray['docName'] . ".php'";
  executeSQL($sql);

  //log event
  $msg = "Subpage: \"" . $subFullArray['docName'] . ".php\" had it\'s title changed: was " . $subFullArray['Title'] . " now $subFullArray[0]";
  $sql = "INSERT INTO Log(user, message) VALUES(" . $_SESSION['user'] . ",'" . $msg . "')";
  executeSQL($sql);
}

///////////////////////
//Document Name
//////////////////////
if($subFullArray[1] != $subFullArray["docName"]){
  //Change url in subpage
  $sql = "UPDATE Subpages SET url = '$subFullArray[1].php' WHERE url = '" . $subFullArray["docName"] . ".php'";
  executeSQL($sql);

  //Change filename
  rename("../../subpages/" . $subFullArray["docName"] . ".php" , "../../subpages/" . $subFullArray[1] . ".php");

  //Migrate all contentboxes to page (change url)
  $sql = "SELECT contentID FROM Content WHERE url='/php/subpages/" . $subFullArray["docName"] . ".php'";
  $result = executeSQL($sql,2);

  foreach ($result as $index => $record) {
    $sql = "UPDATE Content SET url='/php/subpages/$subFullArray[1].php' WHERE contentID = $record[0]";
    executeSQL($sql);
  }

  //log event
  $msg = "Subpage: \"" . $subFullArray['docName'] . ".php\" had it\'s document name changed it is now $subFullArray[1]";
  $sql = "INSERT INTO Log(user, message) VALUES(" . $_SESSION['user'] . ",'" . $msg . "')";
  executeSQL($sql);
}

///////////////////////
//Delete File
//////////////////////
if(!empty($subFullArray[2])){
  $password = hash('sha256', $subFullArray[2]); // password hashing using SHA256
    //Saltyfries
  $SQL = executeSQL("SELECT userPass FROM User WHERE userId='" . $_SESSION['user'] . "'", 1);
    //Get real hashed and salted password
  $Realpass = $SQL[0]["userPass"]; //Queryresult[rownumber]["collumnname"]
    //Validate the password
  $ValidPass = password_verify($password, $Realpass);

  if($ValidPass){
    //Actually remove file
    unlink("../../subpages/$subFullArray[1].php");
  }else{
    echo json_encode("INVALID PASSWORD");
  }
}
echo json_encode($subFullArray);

 ?>
