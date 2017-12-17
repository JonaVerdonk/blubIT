$(document).ready(function() {
    var data;

    //Ajax request to get the data from the database.
    //The executeQuery.php returns a JSON string
    $.ajax({
        url: "../../scripts/executeQuery.php",
        type: "POST",
        data: {"sql": "SELECT * FROM Homepage;"},
        success: function(json, status) {
            //When the ajax query is succesfull, save the databse data as an array in 'data'.
            data = $.parseJSON(json);

            $("#image img").attr("src", "../../"+data[0][0]);
            $("#url").html('<a href="../../'+data[0][0]+'">'+data[0][0]+'</a>');

            setEditImg(data);

            $("#showText").html(data[0][1]);

            setEditText(data);
        }
    });
});

function setEditImg(data) {
    $("#editImg").on("click", function() {
        if ($(this).html() == "Edit") {
            $(this).html("Save");
            var val = $("#url a").html();
            $("#url").html("<input class='inpTextBig' type='text' value='"+val+"'>");
        } else {
            $(this).html("Edit");
            var val = $("#url input").val();
            $("#url").html('<a href="../../'+val+'">'+val+'</a>');
            $("#image img").attr("src", "../../"+val);

            if (val !== data[0][0]) {
                updateDB("UPDATE Homepage SET bgImage='"+val+"';");
                data[0][0] = val;
            }
        }
    });
}

function setEditText(data) {
    $("#editText").on("click", function() {
        if ($(this).html() == "Edit") {
            $(this).html("Save");
            var val = $("#showText").html();
            $("#showText").html("<input class='inpTextBig' type='text' value='"+val+"'>");
        } else {
            $(this).html("Edit");
            var val = $("#showText input").val();
            $("#showText").html(val);

            if (val !== data[0][1]) {
                updateDB("UPDATE Homepage SET maintext='"+val+"';");
                data[0][1] = val;
            }
        }
    });
}
