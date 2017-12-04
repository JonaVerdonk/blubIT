<?php
print "voor logout \n";
$_SESSION['user'] = 0;
$_SESSION['role'] = 'r';
$_SESSION['logged_in'] = 0;
print "Na logout";
header("location: /php/login.php");
 ?>
