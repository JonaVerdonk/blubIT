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

                    //Ajax request to get the data from the database.
                    //The executeQuery.php returns a JSON string
                    $.ajax({
                        url: "../../scripts/executeQuery.php",
                        type: "POST",
                        data: {"sql": "SELECT * FROM Navbar ORDER BY position;"},
                        success: function(json, status) {
                            //When the ajax query is succesfull, save the databse data as an array in 'data'.
                            data = $.parseJSON(json);

                            //Change all positions from strings to ints
                            for (var i = 0; i < data.length; ++ i) {
                                data[i][2] = parseInt(data[i][2]);
                            }
                            /*
                                data
                                    [0] = URL
                                    [1] = Name
                                    [2] = Position
                            */
                            //Show the array on the page.
                            print();

                        }
                    });

                    function print() {
                        //Empty the entire table
                        $("#navbarTable").empty();

                        //Sort the array on 'position' property
                        data.sort(function(a, b) {
                            return a[2] - b[2];
                        });

                        //Append the table header to the table
                        app("<tr><th>Order</th><th>URL</th><th>Name</th></tr>");
                        //Sorry voor deze lijn, dit is de enige manier dat ik dit werkend kon krijgen zonder dat jquery automatisch tags begon te sluiten.
                        for (row = 0; row < data.length; ++ row) {
                            //For every data entry create a table row
                            app("<tr id='"+row+"'><td class='position'><button value='"+row+"' class='up'>&#9650;</button><br>"+data[row][2]+"<br><button class='down' value='"+row+"'>&#9660;</button></td><td class='url'>"+data[row][0]+"</td><td class='name'>"+data[row][1]+"</td><td><button value='"+row+"' class='edit'>Edit</button> <button value='"+row+"' class='delete'>Delete</button></td></tr>");
                        }
                        //Append a row for adding a new navbar entry
                        app("<tr><td id='positionNew'></td><td><input id='urlNew' type='text'></td><td><input id='nameNew' type='text'></td><td><button id='saveNew'>Save new entry</button></td>");

                        //Set event listeners to buttons
                        setEditClick();
                        setPosClick();

                        //Set event listener for saving a new line
                        $("#saveNew").on("click", function() {
                            //Create a new array index and save url, name and position.
                            //After new entry is saved, print the table again
                            data[data.length] = [
                                $("#urlNew").val(),
                                $("#nameNew").val(),
                                data.length + 1
                            ];
                            changed();
                            print();
                        });
                    }

                    function setEditClick() {
                        //Get all buttons with 'edit' class
                        var btnEdit = $(".edit");
                        var btnDelete = $(".delete");



                        btnEdit.on("click", function() {
                            //Get current row being edited
                            var row = $(this).val();

                            if ($("#"+row+" .edit").html() === "Edit") {
                                //Change text to inputs with value of the original text and change the 'edit' btn to a 'save' button
                                $("#"+row+" .url").html("<input type=text value='"+data[row][0]+"'>");
                                $("#"+row+" .name").html("<input type=text value='"+data[row][1]+"'>");
                                $("#"+row+" .edit").html("Save");
                            } else {
                                //If 'save' is clicked, get url and name from the text input
                                var url = $("#"+row+" .url input").val();
                                var name = $("#"+row+" .name input").val();

                                //Save the url and name in data
                                data[row][0] = url;
                                data[row][1] = name;

                                //Change the input fields to just text and set the 'save' btn to 'edit'
                                $("#"+row+" .url").html(url);
                                $("#"+row+" .name").html(name);
                                $("#"+row+" .edit").html("Edit");

                                changed();
                            }
                        });

                        btnDelete.on("click", function() {
                            //Get current row being edited
                            var row = $(this).val();

                            //Splice the entry from 'data'
                            data.splice(row, 1);

                            //Move all entry below 'row' one up
                            for (i = row; i < data.length; ++ i) {
                                data[i][2] --;
                            }

                            print();
                            changed();
                        });
                    }

                    function setPosClick() {
                        //Get all up and down buttons
                        var btnPosUp = $(".up");
                        var btnPosDown = $(".down");

                        btnPosUp.on("click", function() {
                            //Get row being edited
                            var row = parseInt($(this).val());

                            //Top row can't go any higher
                            if (row !== 0) {
                                //Move current row one up, and the one above it one one down
                                data[row][2] --;
                                data[row-1][2] ++;
                                changed();
                                print();
                            }
                        });

                        btnPosDown.on("click", function() {
                            var row = parseInt($(this).val());
                            if (row !== data.length-1) {
                                //Same concept as 'move up', move this row down and the one below it one up
                                data[row][2] ++;
                                data[row+1][2] --;
                                changed();
                                print();
                            }
                        });
                    }

                    function changed() {
                        //Every time this function is called add class clickable and remove notClickable to the save btn.
                        $("#btnSave").addClass("clickable");
                        $("#btnSave").removeClass("notClickable");

                        //Add an event listener to the save btn, but unbind it first so it is never called twice.
                        $("#btnSave").unbind("click");
                        $("#btnSave").on("click", function() {
                            //When clicked, set its class to notClickable
                            $("#btnSave").addClass("notClickable");
                            $("#btnSave").removeClass("clickable");

                            //Delete everything from navbar because I don't know how else to do this.
                            var sql = "DELETE FROM Navbar;";
                            for (i = 0; i < data.length; ++ i) {
                                //And then add everything again.
                                //This is because I don't know how to check if the current row was deleted, edited, inserted or whatever
                                sql += "INSERT INTO Navbar (url, name, position) VALUES ('"+data[i][0]+"', '"+data[i][1]+"', "+parseInt(data[i][2])+");";
                            }

                            //After all sql is added to one string, use an ajax request to send the query to the database
                            $.ajax({
                                url: "../../scripts/executeQuery.php",
                                type: "POST",
                                data: {"sql": sql},
                                success: function(json, status) {
                                    alert(status);
                                },

                                error: function(data) {
                                    alert("Error, most likely related to database connection. Fired from ajax request.");
                                }
                            });
                        });
                    }

                    function app(str) {
                        //Function to make appending to the navbarTable easier
                        $("#navbarTable").append(str);
                    }

                    function log(str) {
                        //Function to log to console easier
                        console.log(str);
                    }
                });
            </script>

        </div>

        <?php include($_SERVER['DOCUMENT_ROOT']."scripts/footer.php"); ?>
    </body>
</html>
