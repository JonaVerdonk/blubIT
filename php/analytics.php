<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <meta charset="UTF-8">
        <title>Analytics</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/analytics.css">
    </head>
    <body>
        <!-- toevoegen header -->
        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");

        // Rechten controleren. W of X rechten vereist.
        if ($_SESSION['role'] == 'r') {
            header("Location: redirect.php");
            exit;
        }
        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
        </script>

        <div id="pageContent">

            <br>
            <div class="btnBack">
                <a href="admin.php">Terug</a>
            </div><br><br><br>

            <div id="graphs">
                <!-- Analytics link naar Bezoekers deze en vorige week -->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1758210873&amp;format=interactive"></iframe>

                <!-- Analytics link naar Nieuwe bezoekers deze en vorige week-->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=2003940080&amp;format=interactive"></iframe>

                <!-- Analytics link naar Browsers-->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1737927130&amp;format=interactive"></iframe>

                <!-- Analytics link naar Locatie Bezoekers-->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=2012125022&amp;format=interactive"></iframe>

                <!-- Analytics link naar device-->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1878881727&amp;format=interactive"></iframe>

                <!-- Analytics link naar Bezoekers per pagina-->
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1619158032&amp;format=interactive"></iframe>
            </div>

        </div>

        <!--Footer toevoegen -->
        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
