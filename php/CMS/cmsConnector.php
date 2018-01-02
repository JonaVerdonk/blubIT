<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/cmsConnector.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php");
        if ($_SESSION['role'] == 'r') {
            header("Location: ../redirect.php");
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
            <div id='imgChanged' class='hidden'><div id='url'></div><div id='id'></div></div>

            <div id="connectors"></div>
            <div id="btnNew"><button class="btnStandard">New</button></div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="/js/ImgSelection.js"></script>
            <script>
                $(document).ready(function() {
                    printConnectors();
                });

                function printConnectors() {
                    //Ajax request to get all  connector data
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Connector;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'
                            var data = $.parseJSON(json);

                            //Empty 'connectors' div before appending all connectors
                            $("#connectors").empty();

                            //For every connector append 'html' wich contains connector img, name, text,
                            // edit/delete buttons and multi/single mode choice
                            for (i = 0; i < data.length; ++ i) {
                                var html = "";
                                html += "<div class='itemContainer'>";
                                html += "<div class='connector'>";
                                html += "<div class='img'><button class='editImg'>Edit</button><img class='conImg' id='"+data[i][0]+"' src='/"+data[i][1]+"' alt='Connector img'></div>";
                                html += "<div class='conTitle'><h2>"+data[i][2]+"</h2></div>";
                                html += "<div class='conText'><p>"+data[i][3]+"</p></div>";
                                html += "</div>";
                                html += "<div class='buttons'>";
                                html += "<button class='btnStandard edit'>Edit</button><br>";
                                html += "<button class='btnStandard delete'>Delete</button>";
                                html += "<select class='btnStandard selectType'>";
                                if (data[i][4] == "multimode") {
                                    html += "<option value='s'>Singlemode</option><option selected value='m'>Multimode</option>";
                                } else {
                                    html += "<option selected value='s'>Singlemode</option><option value='m'>Multimode</option>";
                                }
                                html += "</select>";
                                html += "</div>";
                                html += "</div>";

                                $("#connectors").append(html);
                            }

                            //Set actions for buttons
                            setEditImg();
                            setSelectType();
                            setBtnEdit();
                            setBtnDelete();
                            setBtnNew(data);
                        }
                    });
                }

                function setEditImg() {
                    //Select all buttons with class 'editImg'
                    var editImg = $(".editImg");

                    //Unbind events so no events are added multiple times
                    editImg.unbind("click");
                    editImg.on("click", function() {
                        //When the button is clicked, find wich image it belongs to
                        var id = $(this).parent().find("img").attr("id");
                        imgEl = "#"+id;

                        //Create a new 'ImgSelection' object with the map to search for images and the img element to change
                        var imgSelection = new ImgSelection("/images", imgEl);
                        //Draw the modal from the 'ImgSelection' object
                        imgSelection.drawModal();
                    });

                    //Hidden input to handle the image being changed. Not pretty, but it works.
                    $("#imgChanged").on("click", function() {
                        //Get the url of the new img and the id of the img element that should be changed
                        var url = $(this).find("#url").html();
                        var id = $(this).find("#id").html();
                        //Update the url in the 'conector' table
                        var sql = "UPDATE Connector SET connector_image='.."+url+"' WHERE connector_ID="+id+";";
                        //Execute the query
                        updateDB(sql);
                    });
                }

                function setSelectType() {
                    //Select all elements with class 'selectType'
                    var select = $(".selectType");

                    //Unbind all events so there are no duplicates
                    select.unbind("change");
                    select.on("change", function() {
                        //When the button is pressed, check wich connector it belongs to
                        var num = $(this).parent().parent().find(".img").find(".conImg").attr("id");
                        var val = $(this).val();

                        //Set correct value
                        if (val == 'm') {type="multimode";} else {type="singlemode";}

                        //Update the type in the database
                        updateDB("UPDATE Connector SET connector_type='"+type+"' WHERE connector_ID="+num+";");
                    });
                }

                function setBtnEdit() {
                    //Get all elements with class 'edit'
                    var btnEdit = $(".edit");

                    //Unbind all events so there are no duplicates
                    btnEdit.unbind("click");
                    btnEdit.on("click", function() {
                        //When the button is clicked, check what connector it belongs to
                        var item = $(this).parent().parent();
                        var num = item.find(".img").find(".conImg").attr("id");

                        if ($(this).html() == "Edit") {
                            //If the button says 'edit', change it to 'save'
                            $(this).html("Save");
                            //In the 'connector' class, find the 'title' class and change it from a 'h2' element to 'input' element
                            item.find(".conTitle").html("<input type='text' value='"+item.find(".conTitle h2").html()+"'>");
                            //Same with changing 'conText' class from 'h2' to 'textarea'
                            item.find(".conText") .html("<textarea>"+item.find(".conText p").html()+"</textarea>");
                        } else {
                            //If the button says 'save' change it to 'edit'
                            $(this).html("Edit");
                            //Get the title and text from the input fields
                            var title = escapeHtml(item.find(".conTitle input").val());
                            var text = escapeHtml(item.find(".conText textarea").val());
                            //Change the inputs to 'h2' and 'p' with the updated values
                            item.find(".conTitle").html("<h2>"+title+"</h2>");
                            item.find(".conText").html("<p>"+text+"</p>");
                            //Create sql query to update the title and text for the correct connector in the database
                            var sql = "UPDATE Connector SET connector_name='"+title+"', connector_text='"+text+"' WHERE connector_ID="+num+";";
                            //Execute the query
                            updateDB(sql);
                        }
                    });
                }

                function setBtnDelete() {
                    //Get all buttons with class 'delete'
                    var btnDelete = $(".delete");

                    //Remove all events to avoid duplicates
                    btnDelete.unbind("click");
                    btnDelete.on("click", function() {
                        //When the button is clicked, find wich connector it belongs to
                        var num = $(this).parent().parent().find(".img").find(".conImg").attr("id");
                        if (confirm("Weet je zeker dat je deze connector wil verwijderen?")) {
                            //If the confirm button is clicked, update the database and execute the 'printConnectors' function by setting the last argument to true
                            updateDB("DELETE FROM Connector WHERE connector_id="+num+";", true);
                        }
                    });
                }

                function setBtnNew(data) {
                    //Select the button in the 'btnNew' id
                    var btnNew = $("#btnNew button");

                    //Unbind events to avoid duplicates
                    btnNew.unbind("click");
                    btnNew.on("click", function() {
                        //Get the last connectorId in the database and add 1 to create a new id
                        var id = parseInt(data[data.length-1][0]) + 1;
                        //Insert new connector in the database with standard values that can than be changed
                        var sql = "INSERT INTO Connector(connector_ID, connector_image, connector_name, connector_text, connector_type) VALUES("+id+", '../../images/connectors/singlemode.jpg', 'New connector', 'New connector text', 'singlemode');";
                        //Execute the query and execute the printConnectors function by setting the last argument to true
                        updateDB(sql, true);
                    });
                }

                //All characters that are to be escaped in html, and the code to change them to
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
                //Function to sanitize html input to avoid cross-site scripting
                function escapeHtml (string) {
                    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
                        return entityMap[s];
                    });
                }

                //Function to update database and print all connectors again if needed.
                //This avoids a lot of ajaxrequests all over the page in an attempt to make it more readable
                function updateDB(sql, print=false) {
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": sql},
                        success: function(json, status) {
                            //alert(json);
                            if (print) {
                                printConnectors();
                            }
                        }
                    });
                }
            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
