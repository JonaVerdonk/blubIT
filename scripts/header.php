<?php

    /*
    * Open connection
    * Get links, logo
    * Close connection
    * Print header with logo and links
    */

    //Set the admin session-variable as test
    $_SESSION["admin"] = true;

    if ($_SERVER["REQUEST_URI"] === "/") {
        //Include and print everything for index
        include("scripts/databaseConnection.php");
        print('<script type="text/javascript" src="js/jquery-3.2.1.js"></script>');
        print('<script type="text/javascript" src="js/header.js"></script>');
    } else {
        //Include and print for other pages
        include("../scripts/databaseConnection.php");
        print('<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>');
        print('<script type="text/javascript" src="../js/header.js"></script>');
    }

    $links = executeSQL("SELECT * FROM Navbar ORDER BY position");
//    for ($i = 0; $i < count($links); ++$i) {
//        for ($j = 0; $j < count($links); ++$j) {
//            print($links[$i][$j]." ");
//        }
//        print("<br>");
//    }
//
//
    //Example array of links
//    $links = [
//        ["/index.php", "Home", 1],
//        ["/php/contact.php", "Contact", 2],
//        ["", "Link 5", 5],
//        ["/#", "Link 3", 3],
//        ["/#", "Link 4", 4],
//        ["/php/admin.php", "Admin page", 6]
//    ];

    //Print the header tag with the header-img
    print('<header>');
    print('<img id="headerImg" src="../images/headerlogo.PNG" alt="logo">');
    //Print the navbar
    print('<div id="navbar">');
    print('<button id="navbarButton">Show links</button>');
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
            if ($_SESSION['admin']) {
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
