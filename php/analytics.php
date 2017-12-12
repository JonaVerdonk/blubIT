<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/analytics.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
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

            <div id="loading" style="display:none;">
                Loading Please Wait....
                <img src="../images/ajax-loader.gif" alt="Loading" />
            </div>

            <div class="btnBack">
                <a href="admin.php">Terug</a>
            </div>

            <div id="graphs">
                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1758210873&amp;format=interactive"></iframe>

                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=2003940080&amp;format=interactive"></iframe>

                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1737927130&amp;format=interactive"></iframe>

                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=2012125022&amp;format=interactive"></iframe>

                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1878881727&amp;format=interactive"></iframe>

                <iframe width="600" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQquF6rNht_LO1J2Bu3OPy4x8ddgNpl_fksyXws6PRj_BOxndkR8yYOVGPyETjw-WYRkyv-QHE2A2qF/pubchart?oid=1619158032&amp;format=interactive"></iframe>
            </div>

        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
