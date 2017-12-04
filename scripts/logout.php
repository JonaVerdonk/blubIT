<?php
print "voor logout \n";
$_SESSION['user'] = 0;
$_SESSION['role'] = 'r';
$_SESSION['logged_in'] = FALSE;
print "Na logout";
 ?>
