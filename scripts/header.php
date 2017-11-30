<?php

    /*
    * Open connection
    * Get links, logo
    * Close connection
    * Print header with logo and links
    */
    session_start();
    //Set the admin session-variable as test
    if (!isset($_SESSION["role"])) {
        $_SESSION["role"] = "r";
    }

    print('<script type="text/javascript" src="/js/jquery-3.2.1.js"></script>');
    print('<script type="text/javascript" src="/js/header.js"></script>');
    
    include_once("databaseConnection.php");

    $links = executeSQL("SELECT * FROM Navbar ORDER BY position");

    //Print the header tag with the header-img
    print('<header>');
    print('<img id="headerImg" src="/images/headerlogo.PNG" alt="logo">');
    //Print the navbar
    print('<div id="navbar">');
    print('<button id="navbarButton">&#9776;</button>');
    print('<ul id="navbarLinks">');
    //Print individual navbar-items
    for ($i = 0; $i < count($links); ++ $i) {
        $url = $links[$i][0];
        $name = $links[$i][1];

        $currentUrl = $_SERVER["REQUEST_URI"];

        if ($currentUrl === $url) {
            $id = 'id="currentPage"';
        } else {
            $id = "";
        }

        //If the name of the link contains the word admin, check if
        //it should be shown to the user (check if the user is an admin
        //Use strpos !== false because it returns either false or an int, not true or false
        if (strpos($name, "Admin") !== false) {
            //Check if user is logged in as admin
            //If so, print the link containing admin
            if ($_SESSION["role"] == "x") {
                print('<li '.$id.'><a class="navbarLink" href="'.$url.'">'.$name.'</a></li>');
            }
        } else {
            print('<li '.$id.'><a class="navbarLink" href="'.$url.'">'.$name.'</a></li>');
        }
    }
    //Print the closing tags
    print('</ul>');
    print('</div>');
    print('</header>');
?>
