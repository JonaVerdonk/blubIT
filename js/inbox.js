$(document).ready(function() {
    print();
});

function print(selectedMsg = 0, selectSelected = true) {
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

            messages = $(".form");
            messages.unbind("click");
            messages.on("click", function() {
                msg = $(this).attr("id");
                $("#name").     html(data[msg][4] + " " + data[msg][5]);
                $("#email").    html(data[msg][6]);
                $("#timestamp").html(data[msg][2]);
                $("#subject").  html(data[msg][7]);
                $("#message").  html(data[msg][8]);
                messages.removeClass("selected");
                $(this).addClass("selected");
                if (data[msg][9] == "0") {
                    setRead(data[msg][0], true);
                }
            });

            if (selectSelected) {
                messages[selectedMsg].click();
            } else {
                messages[0].click();
            }

            $("#delete").unbind("click");
            $("#delete").on("click", function() {
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
                $("#subject").toggle();
                $("#message").toggle();
                if ($("#replybox").html() == "") {
                    $("#replybox").html("<textarea>&#10;&#10;&#10;&#10;_______________&#10;"+$("#subject").html()+"&#10;&#10;"+$("#message").html()+"</textarea><br><button id='btnSend'>Verzenden</button>");
                } else {
                    $("#replybox").empty();
                }
            });
        }
    });


}

function deleteMsg(id) {
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
            print(getIndexFromId(id), read);
        }
    });
}

function getIndexFromId(id) {
    for (i = 0; i < data.length; ++ i) {
        if (data[i][0] == id) {
            return i;
        }
    }
    return "Error: message not found";
}

function log(str) {
    console.log(str);
}
