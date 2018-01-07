<?php
//This file contains all functions and functionality of the content cms CMSToolbar
//CMS move/resize tool, CMS Menu (Content editor).

//Start sessions
session_start();


//Verify user
if(!isset($_SESSION['role']) || $_SESSION['role'] == "r"){
  return;
}

//User is logged in and has write or execute rights

/****************************************************
******************CMS MENU(Content editor)***********
****************************************************/
class CMSMenu {
  //Contains all behavior of cmsMenu
  public function printHTML(){
    echo"
      <div id='CMSToolbar'>
        <div id='CMSToolbar-Header'>CMS MENU</div>
        <div id='CMSToolbar-Body'>
          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-edit'>Edit Mode</div>
          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-addcont'>Add content</div>
          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-remcont'>Remove content</div>
          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-add'>Verander naar</div>
        </div>
      </div>
    ";
  }

  //          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-remove'>Pas aan</div>
  //          <div class='CMSToolbar-Body-item' id='CMSToolbar-Body-button-move'>Zet terug</div>

  public function linkCSS(){
    echo"<link rel='stylesheet' href='../../css/CMSToolbar.css'>";
  }
  public function printJquary(){
    echo "<script type='text/javascript'>var url = '\"" . $_SERVER['PHP_SELF'] . "\"';var userID = '" . $_SESSION['user'] . "';</script>";
    echo "<script src='/js/CMSContentTools.js'></script>";
    echo "<script src='/js/modalIMG.js'></script>";
  }
}

class CMSmoveTool{
  public function printJquary(){
    echo "<script type='text/javascript'>var string = " . $this->CreateModal() . ";var url = '\"" . $_SERVER['PHP_SELF'] . "\"';var userID = '" . $_SESSION['user'] . "';</script>";
    echo "<script src='/js/CMSmoveTool.js'></script>";
  }
  private function CreateModal(){
    return "\"<div id='cmsMoveTool-background'><div id='cmsMoveTool-body'><div id='cmsMoveTool-body-content'><div id='cmsMoveTool-body-content-info'><div id='cmsMoveTool-body-content-kolom'><div id='cmsMoveTool-body-content-kolom-value'></div><div id='cmsMoveTool-body-content-kolom-text' title='De kolom het element staat'>kolom</div></div><div id='cmsMoveTool-body-content-rij'><div id='cmsMoveTool-body-content-rij-value'></div><div id='cmsMoveTool-body-content-rij-text' title='De rij het element staat'>Rij</div></div><div id='cmsMoveTool-body-content-breedte'><div id='cmsMoveTool-body-content-breedte-value'></div><div id='cmsMoveTool-body-content-breedte-text' title='de hoeveel kollomen die de element vult'>breedte</div></div><div id='cmsMoveTool-body-content-hoogte'><div id='cmsMoveTool-body-content-hoogte-value'></div><div id='cmsMoveTool-body-content-hoogte-text' title='De hoeveelheid rijen die de element vult'>Hoogte</div></div></div><div id='cmsMoveTool-body-content-clickers'><div id='cmsMoveTool-body-content-clickers-movement'><div id='cmsMoveTool-body-content-clickers-moveup' class='CmsMoveTool-button'>&#8593</div><div id='cmsMoveTool-body-content-clickers-movedown' class='CmsMoveTool-button'>&#8595</div><div id='cmsMoveTool-body-content-clickers-moveleft' class='CmsMoveTool-button'>&#8592;</div><div id='cmsMoveTool-body-content-clickers-moveright' class='CmsMoveTool-button'>&#8594</div></div><div id='cmsMoveTool-body-content-clickers-add-breedte' class='CmsMoveTool-button'>&#8594</div><div id='cmsMoveTool-body-content-clickers-add-hoogte' class='CmsMoveTool-button'>&#8594</div><div id='cmsMoveTool-body-content-clickers-remove-breedte' class='CmsMoveTool-button'>&#8592;</div><div id='cmsMoveTool-body-content-clickers-remove-hoogte' class='CmsMoveTool-button'>&#8592;</div></div></div></div></div>\"";
  }
}
//Initialize the class
$CMSMenu = new CMSMenu;
$CMSmoveTool = new CMSmoveTool;

//Print with the functions
$CMSMenu->linkCSS();
$CMSMenu->printHTML();
$CMSMenu->printJquary();

$CMSmoveTool->printJquary();
/*

//Print the html

*/
?>
