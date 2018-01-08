<?php
    //If the submit button is clicked
    if (isset($_POST["Verstuur"])) {
        //Include the database connection
        include_once("../scripts/databaseConnection.php");

        //Get the ID of the last message, so for the new message a new ID can be generated.
        //This way no duplicate ID's will be created
        $prevId = executeSql("SELECT MAX(messageId) FROM Message");
        //Select the ID
        $id = intval($prevId[0][0]);
        //New ID
        $id ++;

        //Captcha check
        //Get the variable the Captcha send
        $response = $_POST["g-recaptcha-response"];
        //If response is true, captcha is passed
        if ($response) {
            //Use the srip_tags to filter any HTML code so style or script tags are not saved in the database

            //If the user is logged in, set the userID to that of the logged in user.
            // if the user is not logged in, set userID to null and continue as 'guest'.
            if ($_SESSION["logged_in"] == 1) {$userId = strip_tags($_SESSION["user"]);} else {$userId = "NULL";}

            //If the company name is set, strip it and set the variable. Otherwise set it to null.
            if (isset($_POST["bedrijfsnaam"])) {$company = strip_tags($_POST["bedrijfsnaam"]);} else {$company = NULL;}

            //Get all the variables from the contact page
            $fName = strip_tags($_POST["firstname"]);
            $lName = strip_tags($_POST["lastname"]);
            $email = strip_tags($_POST["email"]);
            $subject = strip_tags($_POST["subject"]);
            $message = strip_tags($_POST["commentaar"]);

            //If connectors are added from the connector page, get them and save them in the connector variable.
            // Otherwise set it as an empty string.
            // When the message is opened in the inbox, it checks if it is an empty string or not. Might not be
            // the best way, but it works for now.
            if (isset($_POST["connectors"])) {
                $conn = $_POST["connectors"];
            } else {
                $conn = "";
            }

            //Once again, not the best way, and if we had time I would rewrite it, but for now it works.
            //If company is not null, send the value with it.
            // If it is not, don't send a value so the datase sets it as null.
            if ($company == NULL) {
                executeSql("INSERT INTO Message(messageId, userId, fName, lName, email, subject, message, connectors)
                            VALUES($id, $userId, '$fName', '$lName', '$email', '$subject', '$message', '$conn');");
                $messagesucces = "Bericht verzonden!";
            } else {
                executeSql("INSERT INTO Message(messageId, userId, company, fName, lName, email, subject, message, connectors)
                            VALUES($id, $userId, '$company', '$fName', '$lName', '$email', '$subject', '$message', '$conn');");
                $messagesucces = "Bericht verzonden!";
            }

        } else {
            //If the captcha is not set, set the error message
            $messagefail = "Vul de reCaptcha juist in.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-109575524-1');
        </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="../css/contact.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Contact</title>
    </head>
    <body>
        <?php include("../scripts/header.php"); ?>

        <div id="pageContent">

             <?php
             //If the succes message is set, print it. Otherwise, of the error message is set, print that.
             if (isset($messagesucces)){
                    print ("<div id='verzonden'>");
                    print($messagesucces);
                    print ("</div>");
                }

                if (isset($messagefail)){
                    print ("<div id='fail'>");
                    print($messagefail);
                   print ("</div>");
                }
                ?>
                <br>

            <div id="form">
                <form action="" method="post" secret="6Led1zsUAAAAAJ-pZ1hIcAzudqKLOV-c5DkriEk9">
                    <h1>Contactformulier</h1>
                    <input class="text" type="text" name="bedrijfsnaam" placeholder="Bedrijfsnaam"><br>
                    <input class="text" type="text" name="firstname" placeholder="*Voornaam" required><br>
                    <input class="text" type="text" name="lastname" placeholder="*Achternaam" required><br>
                    <input class="text" type="email" name="email" placeholder="*Email" required><br>
                    <input class="text" type="text" name="subject" placeholder="*Onderwerp" required><br>
                    <?php /*Get the connectors if those are added.*/ include_once("../scripts/Save.php"); ?>
                    <textarea id="comment" name="commentaar" type="text" placeholder="Typ hier je bericht"></textarea><br>
                    <span>
                        <div class="g-recaptcha" data-sitekey="6LeSEDwUAAAAAIo_9WJde77o8BReLbuLaap-tCLE"></div><br>
                        <input id="submit" type="submit" name="Verstuur" value="Verstuur" class="btnStandard">
                    </span>
                </form>
            </div>

            <div id="contact">
                <h1>Contactgegevens</h1>
                    <p>
                        Meijer Glasvezeltechniek<br>
                        Dijkweg 29<br>
                        6905 BA Oud-Zevenaar<br>
                        Tel. +31 611644811<br>
                        info@MeijerGlasvezeltechniek.nl<br>
                        KvK nummer 09173546<br><br>
                        <iframe id="google" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2460.9461877678623!2d6.0836739158328905!3d51.916692888515236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c79f0d453eca6d%3A0x8e64fcf3246a4940!2sDijkweg+29%2C+6905+BA+Zevenaar!5e0!3m2!1snl!2snl!4v1511179502205" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe><br>
                    </p>
                </div>
            </div>

        <?php include("../scripts/footer.php"); ?>

    </body>
</html>
