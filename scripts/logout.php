<?php
$_SESSION['user'] = 0;
$_SESSION['role'] = 'r';
$_SESSION['logged_in'] = 0;
print_r($_SESSION);
header("location: /php/login.php");
 ?>
