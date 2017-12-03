<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/cmsNavbar.css">
    </head>
    <body>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/header.php"); ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-109575524-1');
        </script>

        <div id="pageContent">


            <table id="navbarTable"></table>
            <br><br>
            <button id="btnSave" class="notClickable">Save</button>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    var data;

                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Navbar ORDER BY position;"},
                        success: function(json, status) {

                            data = $.parseJSON(json);
                            /*
                                data
                                    [0] = URL
                                    [1] = Name
                                    [2] = Position
                            */
                            print();

                        }
                    });

                    function print() {
                        $("#navbarTable").empty();

                        data.sort(function(a, b) {
                            return a[2] - b[2];
                        });

                        app("<tr><th>Order</th><th>URL</th><th>Name</th></tr>");
                        //Sorry voor deze lijn, dit is de enige manier dat ik dit werkend kon krijgen zonder dat jquery automatisch tags begon te sluiten.
                        for (row = 0; row < data.length; ++ row) {
                            app("<tr id='"+row+"'><td class='position'><button value='"+row+"' class='up'>&#9650;</button><br>"+data[row][2]+"<br><button class='down' value='"+row+"'>&#9660;</button></td><td class='url'>"+data[row][0]+"</td><td class='name'>"+data[row][1]+"</td><td><button value='"+row+"' class='edit'>Edit</button></td></tr>");
                        }

                        setEditClick();
                        setPosClick();
                    }

                    function setEditClick() {
                        var btnEdit = $(".edit");

                        btnEdit.on("click", function() {
                            var row = $(this).val();
                            if ($("#"+row+" .edit").html() === "Edit") {
                                $("#"+row+" .url").html("<input type=text value='"+data[row][0]+"'>");
                                $("#"+row+" .name").html("<input type=text value='"+data[row][1]+"'>");
                                $("#"+row+" .edit").html("Save");
                            } else {
                                var url = $("#"+row+" .url input").val();
                                var name = $("#"+row+" .name input").val();

                                data[row][0] = url;
                                data[row][1] = name;

                                $("#"+row+" .url").html(url);
                                $("#"+row+" .name").html(name);

                                $("#"+row+" .edit").html("Edit");

                                changed();
                            }
                        });
                    }

                    function setPosClick() {
                        var btnPosUp = $(".up");
                        var btnPosDown = $(".down");

                        btnPosUp.on("click", function() {
                            var row = parseInt($(this).val());
                            if (row !== 0) {
                                data[row][2] --;
                                data[row-1][2] ++;
                                changed();
                                print();
                            }
                        });

                        btnPosDown.on("click", function() {
                            var row = parseInt($(this).val());
                            if (row !== data.length-1) {
                                log(typeof(row));
                                data[row][2] ++;
                                data[row+1][2] --;
                                changed();
                                print();
                            }
                        });
                    }

                    function changed() {
                        $("#btnSave").addClass("clickable");
                        $("#btnSave").removeClass("notClickable");

                        $("#btnSave").on("click", function() {
                            $("#btnSave").addClass("notClickable");
                            $("#btnSave").removeClass("clickable");

                            for (i = 0; i < data.length; ++ i) {
                                //Database connection
                            }
                        });
                    }

                    function app(str) {
                        $("#navbarTable").append(str);
                    }

                    function log(str) {
                        console.log(str);
                    }
                });
            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
