<?php
function HashPass($password){
  //MAKE ME WHOLE
  return password_hash($password, PASSWORD_BCRYPT, array("cost" => 15));
}
 ?>
