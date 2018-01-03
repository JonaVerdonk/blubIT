$(document).ready(function() {
    print();
});

function print(selectedMsg = 0, selectSelected = true) {
    //Get all data from the 'message' table from the db
    $.ajax({
        url: "../scripts/executeQuery.php",
        type: "POST",
        data: {"sql": "SELECT * FROM Message ORDER BY timestamp DESC;"},
        success: function(json, status) {
            //When the ajax query is succesfull, save the databse data as an array in 'data'.
            data = $.parseJSON(json);

            //Print all messages on the left side
            $("#formList").empty();
            for (var i = 0; i < data.length; ++ i) {
                var name = data[i][4]+" "+data[i][5];
                if (data[i][9] == "0") {var readClass = "notRead'";} else {var readClass = "";}
                $("#formList").append("<div class='form "+readClass+"' id='"+i+"'><span id='subjectPreview'>"+data[i][7]+"</span><br><span id='namePreview'>"+name+"</span></div>");
            }

            //Get all messages on the left and unbind click events to avoid duplicates
            messages = $(".form");
            messages.unbind("click");
            messages.on("click", function() {
                //When a message is clicked, get the message id
                msg = $(this).attr("id");
                //If there are no added connectors, just print the message. Else print the message plus the connectors
                if (data[msg][10] !== "" && data[msg][10] !== "NULL" && data[msg][10] !== "null") {
                    var message = data[msg][8] + "<br><br><br>_______________<br>Toegevoegde connectoren: " + data[msg][10];
                } else {
                    var message = data[msg][8];
                }

                if (data[msg][3] !== "" && data[msg][3] !== null) {
                    $("#company").html("Bedrijf: <b>" + data[msg][3] + "</b>");
                } else {
                    $("#company").empty();
                }

                //Set the names, time etc. in the messagebox to the currently selected message
                $("#name").     html(data[msg][4] + " " + data[msg][5]);
                $("#email").    html(data[msg][6]);
                $("#timestamp").html(data[msg][2]);
                $("#subject").  html(data[msg][7]);
                $("#message").  html(message);

                //Remove the 'selected' class from all messages and add it to the currently selected one.
                messages.removeClass("selected");
                $(this).addClass("selected");

                //Set the 'read' variable in the database if it is clicked and not read
                if (data[msg][9] == "0") {
                    setRead(data[msg][0], true);
                }
            });

            //SelectSelected is usually set to true, just clicks the message that was selected when the function
            // function was called. Not entirely sure if it would ever be necessary to set it to false.
            if (selectSelected) {
                messages[selectedMsg].click();
            } else {
                messages[0].click();
            }

            //Unbind all delete buttons to avoid duplicates
            $("#delete").unbind("click");
            $("#delete").on("click", function() {
                //If admin clicks confirm, delete the selected message
                if (confirm("Weet je zeker dat je dit bericht wil verwijderen?")) {
                    deleteMsg(data[msg][0]);
                }
            });

            $("#setUnread").unbind("click");
            $("#setUnread").on("click", function() {
                setRead(data[msg][0], false);
            });

            $("#reply").unbind("click");
            $("#reply").on("click", function() {
                //Toggle the visibility of the subject and message when the reply button is clicked
                $("#subject").toggle();
                $("#message").toggle();

                //If the replybox is empty there is no textarea yet, so create one with the message and sender etc. in it
                if ($("#replybox").html() == "") {
                    $("#replybox").html("<textarea>&#10;&#10;&#10;&#10;_______________&#10;"+$("#subject").html()+"&#10;&#10;"+$("#message").html()+"</textarea><br><button id='btnSend' class='btnStandard'>Verzenden</button>");

                    $("#btnSend").unbind("click");
                    $("#btnSend").on("click", function() {
                        //If the send button is clicked, create an ajax request to the 'mail.php' file.
                        //Doesn't work, need to have a working mailserver first or something
                        $.ajax({
                            url: "../scripts/mail.php",
                            type: "POST",
                            data: {"to": data[msg][6], "subject": $("#subject").html(), "msg": $("#message").html()},
                            success: function(json, status) {
                                alert(json + " " + status);
                                // if (json) {
                                //     alert("Message sent");
                                // } else {
                                //     alert("Something went wrong");
                                // }
                            }
                        });
                    });
                } else {
                    //If the reply box was not empty, it should be, so empty the replybox.
                    $("#replybox").empty();
                }
            });
        }
    });

}

function deleteMsg(id) {
    //Execute a query which deletes the message gotten from the argument.
    //Reprint the messages after that so the deleted message isn't visible anymore.
    $.ajax({
        url: "../scripts/executeQuery.php",
        type: "POST",
        data: {"sql": "DELETE FROM Message WHERE messageId="+id+";"},
        success: function(json, status) {
            print();
        }
    });
}

function setRead(id, read) {
    //Toggle the 'msgRead' column in the message table for the message gottenin the argument.
    if (read) {
        var sql = "UPDATE Message SET msgRead = 1 WHERE messageId="+id+";"
    } else {
        var sql = "UPDATE Message SET msgRead = 0 WHERE messageId="+id+";"
    }

    $.ajax({
        url: "../scripts/executeQuery.php",
        type: "POST",
        data: {"sql": sql},
        success: function(json, status) {
            //Reprint with the selected message selected
            print(getIndexFromId(id), read);
        }
    });
}

//Function to get the array index from a message when only it's ID is known
function getIndexFromId(id) {
    for (i = 0; i < data.length; ++ i) {
        if (data[i][0] == id) {
            return i;
        }
    }
    return "Error: message not found";
}

//Function so I don't have to keep typing 'console.'
function log(str) {
    console.log(str);
}
