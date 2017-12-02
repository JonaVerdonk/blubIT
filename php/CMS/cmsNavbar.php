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

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    var data, originalData;

                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Navbar ORDER BY position;"},
                        success: function(json, status) {

                            data = $.parseJSON(json);
                            originalData = data;

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
                        app("<tr><th>Order</th><th>URL</th><th>Name</th></tr>");
                        //Sorry voor deze lijn, dit is de enige manier dat ik dit werkend kon krijgen zonder dat jquery automatisch tags begon te sluiten.
                        for (row = 0; row < data.length; ++ row) {
                            $("#navbarTable").append("<tr id='"+row+"'><td class='position'><button class='up'>&#9650;</button><br>"+data[row][2]+"<br><button class='down'>&#9660;</button></td><td class='url'>"+data[row][0]+"</td><td class='name'>"+data[row][1]+"</td><td><button value='"+row+"' class='edit'>Edit</button></td></tr>");
                        }

                        setEditClick();
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
                                data[row][0] = $("#"+row+" .url input").val();
                                data[row][1] = $("#"+row+" .name input").val();
                                $("#"+row+" .edit").html("Edit");
                                print();
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
