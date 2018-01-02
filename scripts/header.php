<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet"> <!--Font-->
<?php

    /*
    * Open connection
    * Get links
    * Close connection
    * Print header with logo and links
    */
    session_start();

    //If the 'role' session var is not set, set it to 'r'
    //New users will automatically get 'r'
    if (!isset($_SESSION["role"])) {
        $_SESSION["role"] = "r";
    }

    //If 'logged_in' is not set, set it to 0
    if (!isset($_SESSION["logged_in"])) {
        $_SESSION["logged_in"] = 0;
    }

    //Print the javascipt header file which handles resizing
    print('<script type="text/javascript" src="/js/jquery-3.2.1.js"></script>');
    print('<script type="text/javascript" src="/js/header.js"></script>');

    include_once("databaseConnection.php");
    //Get all data from the 'navbar' table
    $links = executeSQL("SELECT * FROM Navbar ORDER BY position");

    //Print the header tag with the header-img
    print('<header>');
    print('<a href="/"><img id="headerImg" src="/images/headerlogo.PNG" alt="logo"></a>');
    //Print username
    print("<div id='navbarUsername'>");
    if ($_SESSION["logged_in"] == 1) {
        print("<img src='/images/icon_person.png'>&nbsp;&nbsp;");
        print($_SESSION["username"]);
    }
    print("</div>");
    //Print the navbar
    print('<div id="navbar">');
    print('<button id="navbarButton">&#9776;</button>');
    print('<ul id="navbarLinks">');
    //Print individual navbar-items
    for ($i = 0; $i < count($links); ++ $i) {
        $url = $links[$i][0];
        $name = $links[$i][1];

        $currentUrl = $_SERVER["REQUEST_URI"];

        //If the url the navbar-item links to is the same as the current url, is links to the page you
        //are currently on and thus gets an id so it gets a constant border-bottom
        if ($currentUrl === $url) {
            $id = 'id="currentPage"';
        } else {
            $id = "";
        }

        //If the name of the link contains the word admin or CMS, check if
        //it should be shown to the user (check if the user is an admin
        //Use strpos !== false because it returns either false or an int, not true or false
        if (strpos($name, "Admin") !== false || strpos($name, "admin") !== false) {

            //Check if user is logged in as admin
            //If so, print the link containing admin
            if ($_SESSION["role"] !== "r") {
                print('<li '.$id.'><a class="navbarLink" href="'.$url.'">'.$name.'</a></li>');
            }

        } else if (strpos($name, "CMS") !== false || strpos($name, "cms") !== false) {

            //Check if the navbar-item is for the cms. If so, at least an 'r' role is needed to see it
            if ($_SESSION["role"] !== "r") {
                print('<li '.$id.'><a class="navbarLink" href="'.$url.'">'.$name.'</a></li>');
            }

        } else if (strpos($name, "log in") !== false || strpos($name, "Log in") !== false || strpos($name, "Login") !== false) {

            //If you are logged in, the login item will change to logout.
            //Otherwise it stays login
            if ($_SESSION["logged_in"] == 1) {
                print('<li '.$id.'><a class="navbarLink" href="/scripts/logout.php">Log uit</a></li>');
            } else {
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
