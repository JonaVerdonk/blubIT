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
        if ($_SESSION['role'] == 'r') {
            header("Location: redirect.php");
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
                <span>Klik op de afbeelding om hem te wijzigen</span><br>
                <div id='items'></div>
                <div id='btnNew'><button class='btnStandard'>New item</button></div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="/js/ImgSelection"></script>
            <script>
                $(document).ready(function() {
                    printItems();
                });

                function printItems() {
                    //Ajax request to get all info from the homepageItem table in the database
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM HomepageItem ORDER BY HomepageItem.order;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            var data = $.parseJSON(json);

                            //Empty the 'items' div
                            $("#items").empty();

                            //For every item on the homepage append html to the 'items' div
                            for (i = 0; i < data.length; ++ i) {
                                //Create the 'html' variable with the img, title, text, edit and delete button
                                var html = "";
                                html += "<div class='content-body-item' id='"+i+"'>";
                                html += "<img id='" + i + "' src='../../"+data[i][1]+"' alt='itemImg'>";
                                html += "<h2>"+data[i][2] + "</h2>";
                                html += "<p>"+data[i][3] + "</p>";
                                html += "<div>" + (data[i][4] == null? "Geen lees meer pagina":data[i][4]) + "</div>";
                                html += "<span><button class='btnStandard editItem' value='"+i+"' id='"+data[i][0]+"'>Edit</button></span>";
                                html += "<span><button class='btnStandard deleteItem' value='"+i+"' id='"+data[i][0]+"'>Delete</button></span>";
                                html += "</div>";
                                $("#items").append(html);
                            }

                            //Set the actions for the buttons
                            setEditItem(data);
                            setDeleteItem(data);
                            setNewItem(data);

                            //Set image updating
                            $("#imgChanged").on("click", function() {
                                //Get the new url for the img and the id for the database entry that should be changed
                                var url = $(this).find("#url").html();
                                var id = $(this).find("#id").html();
                                //Create the query and execute it
                                var sql = "UPDATE HomepageItem SET img='"+url+"' WHERE HomepageItem.order="+id+";";
                                updateDB(sql);
                            });
                        }
                    });
                }

                function setEditItem(data) {
                    //Get all buttons with class 'editItem'
                    var btnEditItem = $(".editItem");

                    //Unbind all events to avoid duplicates
                    btnEditItem.unbind("click");
                    btnEditItem.on("click", function() {
                        //When the button is clicked, get the item it belongs to
                        var item = $(this).val();
                        var num = item;
                        item = "#"+item;
                        var btn = $(item+" span .editItem");

                        if (btn.html() == "Edit") {
                            btn.html("Save");
                            $(item + " h2").html("<input type='text' value='"+$(item+" h2").html()+"'>");
                            $(item + " p").html("<textarea>"+$(item+" p").html()+"</textarea>");

                            //start of suppage printing
                            //Get currrent subpage
                            var Csubpage = $(this).parents(".content-body-item").children("div").html();
                            var html = "";
                            html += "<select>";
                            html += "<option" + (Csubpage == "Geen lees meer pagina"? " selected":"") + ">Geen lees meer pagina</option>";

                            //All subpages
                            var subpages = <?php echo json_encode(array_diff(scandir("../subpages"),array(".",".."))); ?>;
                            for (var f = 2; f < Object.keys(subpages).length + 2; f++) {
                              html += "<option" + (Csubpage == subpages[f]? " selected":"") + ">" + subpages[f] + "</option>";
                            }
                            html += "</select>";
                            $(this).parents(".content-body-item").children("p").after(html);
                            //End of subpage printing
                        } else {
                            btn.html("Edit");
                            data[num][2] = $(item + " h2 input").val();
                            data[num][3] = $(item + " p textarea").val();
                            data[num][4] = $(item + " select").val();

                            log(data[num][4]);
                            $(item + " h2").html(data[num][2]);
                            $(item + " p").html(data[num][3]);
                            $(item + " div").html(data[num][4]);

                            var id = $(this).attr("id");

                            var sql = "UPDATE HomepageItem SET title='"+data[num][2]+"', text='"+data[num][3]+"', subpage='" + data[num][4] + "' WHERE HomepageItem.order="+id+";";
                            log(sql);
                            escapeHtml(sql);
                            updateDB(sql);

                            //Remove subpages select
                            $(this).parents(".content-body-item").children("select").remove();
                        }
                    });

                    //Remove all events to avoid duplicates
                    $(".content-body-item img").unbind("click");
                    $(".content-body-item img").on("click", function() {
                        //Create a new ImgSelection object
                        var imgId = "#"+$(this).attr("id");
                        var imgSelection = new ImgSelection("/images", imgId);
                        imgSelection.drawModal();
                    });
                }

                function setNewItem(data) {
                    //Unbind all events to avoid duplicates
                    $("#btnNew button").unbind("click");
                    $("#btnNew button").on("click", function() {
                        //Get the id of the last item and add one to it to get the new id
                        var newOrder = parseInt(data[data.length-1][0]) + 1;
                        //Create and execute query to insert a new item with standard values that can than be changed
                        var sql = "INSERT INTO HomepageItem VALUES("+newOrder+", 'Image', 'New item', 'New text');";
                        updateDB(sql, true);
                    });
                }

                function setDeleteItem(data) {
                    //Get all delete buttons
                    var btnDeleteItem = $(".deleteItem");

                    //Unbind all events to avoid duplicates
                    btnDeleteItem.unbind("click");
                    btnDeleteItem.on("click", function() {
                        //Get the item to be deleted
                        var item = $(this).val();
                        var id = $(this).attr("id");

                        if (confirm("Weet je zeker dat je dit item wil verwijderen?")) {
                            //If the admin confirms, delete the item from the database
                            var sql = "DELETE FROM HomepageItem WHERE HomepageItem.order="+id+";";
                            updateDB(sql, true);
                        }
                    });
                }

                //All characters that need to be changed to sanitize HTML
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
                //Function to sanitize HTML to prevent cross site scripting
                function escapeHtml (string) {
                    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
                        return entityMap[s];
                    });
                }

                //Easier log function to prevent extra typing
                function log(str) {
                    console.log(str);
                }

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
            <script src="../../js/cmsHomepageHeader"></script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
