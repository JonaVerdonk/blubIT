<link rel="stylesheet" href="../css/CMSToolbar.css">
<?php
$ContentAdmin = true; //Has admin rights

if($ContentAdmin){
  echo"
  <div id='CMSToolbar'>
    <div id='Button_EditMode'>
     <span>Edit</span>
    </div>
    <div id='Button_AddText'>
      <span>add text</span>
    </div>
    <div id='Button_AddImage'>
      <span>add image</span>
    </div>
    <div id='Button_AddTable'>
      <span>add table</span>
    </div>
  </div>
  ";
}
 ?>
