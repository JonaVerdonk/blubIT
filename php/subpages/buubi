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
                    URL: <span id="url"></span><br><br>
                    <button class="btnStandard btnEdit" id="editImg">Edit</button>
                </div>

                <div id="text">
                    Text over de afbeelding op de homepagina:<br>
                    <div id="showText"></div><br>
                    <button class="btnStandard btnEdit" id="editText">Edit</button>
                </div>
            </div>

            <div id="items">

            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM HomepageItem ORDER BY 'order';"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            var data = $.parseJSON(json);

                            for (i = 0; i < data.length; ++ i) {
                                var html = "";
                                html += "<div class='content-body-item' id='"+i+"'>";
                                html += "<img id='"+i+"' src='../../"+data[i][1]+"' alt='itemImg'>";
                                html += "<h2>"+data[i][2]+"</h2>";
                                html += "<p>"+data[i][3]+"</p>";
                                html += "<span><button class='btnStandard editItem' value='"+i+"'>Edit</button></span>";
                                html += "</div>";
                                $("#items").append(html);
                            }

                            setEditItem(data);
                        }
                    });
                });

                function setEditItem(data) {
                    var btnEditItem = $(".editItem");

                    btnEditItem.on("click", function() {
                        var item = $(this).val();
                        var num = item;
                        item = "#"+item;
                        var btn = $(item+" span button");

                        if (btn.html() == "Edit") {
                            btn.html("Save");
                            $(item + " h2").html("<input type='text' value='"+$(item+" h2").html()+"'>");
                            $(item + " p").html("<textarea>"+$(item+" p").html()+"</textarea>");
                        } else {
                            btn.html("Edit");
                            data[num][2] = $(item + " h2 input").val();
                            data[num][3] = $(item + " p textarea").html();

                            $(item + " h2").html(data[num][2]);
                            $(item + " p").html(data[num][3]);
                            log("update starting");
                            updateDB("UPDATE HomepageItem SET title='"+data[num][2]+"', text='"+data[num][3]+";");
                            log("Update done");
                        }
                    });

                    $(".content-body-item img").on("dblclick", function() {
                        alert("Change image for item "+$(this).attr("id"));
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
            <script src="../../js/cmsHomepageHeader"></script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
