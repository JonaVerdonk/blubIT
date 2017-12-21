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

            <div id='imgChanged' class='hidden'><div id='url'></div><div id='id'></div></div>

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

            <div id="itemsWrapper">
                <div id='items'></div>
                <div id='btnNew'><button class='btnStandard'>New item</button></div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
            function updateDB(sql, print=false) {
                $.ajax({
                    url: "../../scripts/executeQuery.php",
                    type: "POST",
                    data: {"sql": sql},
                    success: function(json, status) {
                        if (print) {
                            printItems();
                        }
                    }
                });
            }
            </script>
            <script src="/js/ImgSelection"></script>
            <script>
                $(document).ready(function() {
                    printItems();
                });

                function printItems() {
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM HomepageItem ORDER BY HomepageItem.order;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            var data = $.parseJSON(json);

                            $("#items").empty();

                            for (i = 0; i < data.length; ++ i) {
                                var html = "";
                                html += "<div class='content-body-item' id='"+i+"'>";
                                html += "<img id='"+i+"' src='../../"+data[i][1]+"' alt='itemImg'>";
                                html += "<h2>"+data[i][2]+"</h2>";
                                html += "<p>"+data[i][3]+"</p>";
                                html += "<span><button class='btnStandard editItem' value='"+i+"' id='"+data[i][0]+"'>Edit</button></span>";
                                html += "<span><button class='btnStandard deleteItem' value='"+i+"' id='"+data[i][0]+"'>Delete</button></span>";
                                html += "</div>";
                                $("#items").append(html);
                            }

                            setEditItem(data);
                            setDeleteItem(data);
                            setNewItem(data);

                            //Set image updating
                            $("#imgChanged").on("click", function() {
                                var url = $(this).find("#url").html();
                                var id = $(this).find("#id").html();

                                var sql = "UPDATE HomepageItem SET img='"+url+"' WHERE order="+id+";";
                                //updateDB(sql);
                                alert(sql);
                            });
                        }
                    });
                }

                function setEditItem(data) {
                    var btnEditItem = $(".editItem");

                    btnEditItem.unbind("click");
                    btnEditItem.on("click", function() {
                        var item = $(this).val();
                        var num = item;
                        item = "#"+item;
                        var btn = $(item+" span .editItem");

                        if (btn.html() == "Edit") {
                            btn.html("Save");
                            $(item + " h2").html("<input type='text' value='"+$(item+" h2").html()+"'>");
                            $(item + " p").html("<textarea>"+$(item+" p").html()+"</textarea>");
                        } else {
                            btn.html("Edit");
                            data[num][2] = $(item + " h2 input").val();
                            data[num][3] = $(item + " p textarea").val();

                            $(item + " h2").html(data[num][2]);
                            $(item + " p").html(data[num][3]);

                            var id = $(this).attr("id");

                            var sql = "UPDATE HomepageItem SET title='"+data[num][2]+"', text='"+data[num][3]+"' WHERE HomepageItem.order="+id+";";

                            escapeHtml(sql);

                            updateDB(sql);
                        }
                    });

                    $(".content-body-item img").unbind("click");
                    $(".content-body-item img").on("click", function() {
                        alert("Change image for item "+$(this).attr("id"));
                        var imgId = "#"+$(this).attr("id");
                        var imgSelection = new ImgSelection("/images", imgId);
                        imgSelection.drawModal();
                    });
                }

                function setNewItem(data) {
                    $("#btnNew button").unbind("click");
                    $("#btnNew button").on("click", function() {
                        var newOrder = parseInt(data[data.length-1][0]) + 1;
                        var sql = "INSERT INTO HomepageItem VALUES("+newOrder+", 'Image', 'New item', 'New text');";
                        updateDB(sql, true);
                    });
                }

                function setDeleteItem(data) {
                    var btnDeleteItem = $(".deleteItem");

                    btnDeleteItem.unbind("click");
                    btnDeleteItem.on("click", function() {
                        var item = $(this).val();
                        var id = $(this).attr("id");

                        if (confirm("Weet je zeker dat je dit item wil verwijderen?")) {
                            var sql = "DELETE FROM HomepageItem WHERE HomepageItem.order="+id+";";
                            updateDB(sql, true);
                        }
                    });
                }

                var entityMap = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                    '/': '&#x2F;',
                    '`': '&#x60;',
                    '=': '&#x3D;'
                };

                function escapeHtml (string) {
                    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
                        return entityMap[s];
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
