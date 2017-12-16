<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsHomepage.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        if ($_SESSION['role'] !== 'x') {
            header("Location: /php/redirect.php");
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

            <div class="btnBack">
                <a href="CMS.php">Terug</a>
            </div><br><br>

            <div id="headerContent">
                <div id="image">
                    Afbeelding op de homepagina:<br><br>
                    <img src="" alt="Homepage image"><br><br>
                    URL: <a href="" id="url"></a><br><br>
                    <button class="btnStandard btnEdit" id="editImg">Edit</button>
                </div>

                <div id="text">
                    Text over de afbeelding op de homepagina:<br>
                    <div id="showText"></div><br>
                    <button class="btnStandard btnEdit" id="editText">Edit</button>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    var data;

                    //Ajax request to get the data from the database.
                    //The executeQuery.php returns a JSON string
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Homepage;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            data = $.parseJSON(json);

                            $("#image img").attr("src", "../../"+data[0][0]);
                            $("#url").attr("href", "../../"+data[0][0]);
                            $("#url").html(data[0][0]);

                            setEditImg();

                            $("#showText").html(data[0][1]);

                            setEditText();
                        }
                    });
                });

                function setEditImg() {
                    $("#editImg").on("click", function() {
                        if ($(this).html() == "Edit") {
                            $(this).html("Save");
                            var val = $("#url").html();
                            $("#url").html("<input type='text' value='"+val+"'>");
                        } else {
                            $(this).html("Edit");
                            var val = $("#url input").val();
                            $("#url").html(val);

                            if (val !== data[0][0]) {
                                updateDB("UPDATE Homepage SET bgImage='"+val+"';");
                            }
                        }
                    });
                }

                function setEditText() {
                    $("#editText").on("click", function() {
                        if ($(this).html() == "Edit") {
                            $(this).html("Save");
                            var val = $("#showText").html();
                            $("#showText").html("<input type='text' value='"+val+"'>");
                        } else {
                            $(this).html("Edit");
                            var val = $("#showText input").val();
                            $("#showText").html(val);

                            if (val !== data[0][1]) {
                                updateDB("UPDATE Homepage SET maintext='"+val+"';");
                            }
                        }
                    });
                }

                function updateDB(sql) {
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": sql},
                        success: function(json, status) {
                            alert("Saved!");
                        }
                    });
                }

                function log(str) {
                    console.log(str);
                }


            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
