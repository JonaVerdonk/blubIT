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
        
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="../css/contact.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title></title>
    </head>
    <body> 
        <?php include("../scripts/header.php"); ?>
        
        <div id="content">
            <div id="form">
                <form action="" method="post">
                    <h1>Contactformulier</h1>
                    <input class="text" type="text" name="bedrijfsnaam" placeholder="Bedrijfsnaam"><br>
                    <input class="text" type="text" name="firstname" placeholder="*Voornaam" required><br>              
                    <input class="text" type="text" name="lastname" placeholder="*Achternaam" required><br>              
                    <input class="text" type="email" name="email" placeholder="*Email" required><br>
                    <input class="text" type="text" name="subject" placeholder="*Onderwerp" required><br>
                    <textarea id="comment" name="commentaar" type="text" placeholder="Typ hier je bericht"></textarea><br>
                    <input id="submit" type="submit" name="Verstuur" value="Verstuur">
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

