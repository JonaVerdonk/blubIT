<?php
<<<<<<< HEAD
$_SESSION['user'] = 0;
$_SESSION['role'] = 'r';
$_SESSION['logged_in'] = 0;
print_r($_SESSION);
=======
print "voor logout \n";
$_SESSION['user'] = 0;
$_SESSION['role'] = 'r';
$_SESSION['logged_in'] = 0;
print "Na logout";
>>>>>>> 7e482dd0f50f8752fdad3552c12ec44f98b7dd70
header("location: /php/login.php");
 ?>
