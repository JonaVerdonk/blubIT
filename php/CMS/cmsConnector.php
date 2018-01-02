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
                })

                function printConnectors() {
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Connector;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            var data = $.parseJSON(json);

                            $("#connectors").empty();
                            console.log(data);

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

                            setEditImg();
                            setSelectType();
                            setBtnEdit();
                            setBtnDelete();
                            setBtnNew(data);
                        }
                    });
                }

                function setEditImg() {
                    var editImg = $(".editImg");

                    editImg.unbind("click");
                    editImg.on("click", function() {
                        var id = $(this).parent().find("img").attr("id");
                        imgEl = "#"+id;
                        var imgSelection = new ImgSelection("/images", imgEl);
                        imgSelection.drawModal();
                    });

                    $("#imgChanged").on("click", function() {
                        var url = $(this).find("#url").html();
                        var id = $(this).find("#id").html();
                        alert(id);
                        var sql = "UPDATE Connector SET connector_image='.."+url+"' WHERE connector_ID="+id+";";

                        updateDB(sql);
                    });
                }

                function setSelectType() {
                    var select = $(".selectType");

                    select.unbind("change");
                    select.on("change", function() {
                        var num = $(this).parent().parent().find(".img").find(".conImg").attr("id");
                        var val = $(this).val();

                        if (val == 'm') {type="multimode";} else {type="singlemode";}

                        updateDB("UPDATE Connector SET connector_type='"+type+"' WHERE connector_ID="+num+";");
                    });
                }

                function setBtnEdit() {
                    var btnEdit = $(".edit");

                    btnEdit.unbind("click");
                    btnEdit.on("click", function() {
                        var item = $(this).parent().parent();
                        var num = item.find(".img").find(".conImg").attr("id");

                        if ($(this).html() == "Edit") {
                            $(this).html("Save");
                            item.find(".conTitle").html("<input type='text' value='"+item.find(".conTitle h2").html()+"'>");
                            item.find(".conText") .html("<textarea>"+item.find(".conText p").html()+"</textarea>");
                        } else {
                            $(this).html("Edit");

                            var title = escapeHtml(item.find(".conTitle input").val());
                            var text = escapeHtml(item.find(".conText textarea").val());

                            item.find(".conTitle").html("<h2>"+title+"</h2>");
                            item.find(".conText").html("<p>"+text+"</p>");

                            var sql = "UPDATE Connector SET connector_name='"+title+"', connector_text='"+text+"' WHERE connector_ID="+num+";";

                            updateDB(sql);
                        }
                    });
                }

                function setBtnDelete() {
                    var btnDelete = $(".delete");

                    btnDelete.unbind("click");
                    btnDelete.on("click", function() {
                        var num = $(this).parent().parent().find(".img").find(".conImg").attr("id");
                        if (confirm("Weet je zeker dat je deze connector wil verwijderen?")) {
                            updateDB("DELETE FROM Connector WHERE connector_id="+num+";", true);
                        }
                    });
                }

                function setBtnNew(data) {
                    var btnNew = $("#btnNew button");

                    btnNew.unbind("click");
                    btnNew.on("click", function() {
                        var id = parseInt(data[data.length-1][0]) + 1;
                        console.log(id);
                        var sql = "INSERT INTO Connector(connector_ID, connector_image, connector_name, connector_text, connector_type) VALUES("+id+", '../../images/connectors/singlemode.jpg', 'New connector', 'New connector text', 'singlemode');";
                        updateDB(sql, true);
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
