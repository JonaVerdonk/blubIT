<?php
//Allow usage of sessions
session_start();

//User needs to be logged in and authorized
if ($_SESSION['role'] == 'r' || $_SESSION['logged_in'] != 1) {
    header("Location: ../../redirect.php");
}
session_start();

$_SESSION['user'] = 30;
$_SESSION['role'] = "x";
$_SESSION['logged_in'] = 1;
$_SESSION['username'] = "DEBUGGER";

?>
