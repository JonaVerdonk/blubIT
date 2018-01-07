<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/imageupload.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        if ($_SESSION['role'] == 'r' && $_SESSION['role'] == 'w') {
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

        <div class="ImageUpload">
          <form enctype="multipart/form-data" action="upload_file.php" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            <p>Choose a file to upload: </p><input name="uploadedfile" type="file" accept="image/*" /><br />
            <input type="submit" value="Upload File" />
          </form>
        </div>

        <?php include("../scripts/footer.php"); ?>
    </body>
</html>
