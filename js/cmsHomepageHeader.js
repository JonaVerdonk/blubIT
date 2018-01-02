/*
    Script for changing the homepage image and the text over it.
    Made into a separate file for readability
*/

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

            //Print the current img and its url
            $("#image img").attr("src", "../../"+data[0][0]);
            $("#url").html('<a href="../../'+data[0][0]+'">'+data[0][0]+'</a>');
            setEditImg(data);

            //Show current text
            $("#showText").html(data[0][1]);
            setEditText(data);
        }
    });
});

function setEditImg(data) {
    $("#editImg").on("click", function() {
        if ($(this).html() == "Edit") {
            //If the 'editImg' button is clicked and the button is set to edit,
            // change the text to an input field with the value of the previous text
            $(this).html("Save");
            var val = $("#url a").html();
            $("#url").html("<input class='inpTextBig' type='text' value='"+val+"'>");
        } else {
            //If the button is set to 'edit' get the data from the input field and
            // change it to text. Then update the image preview to the updated url
            $(this).html("Edit");
            var val = $("#url input").val();
            $("#url").html('<a href="../../'+val+'">'+val+'</a>');
            $("#image img").attr("src", "../../"+val);

            //If the value changed, update it in the database. Only do it than to prevent
            // unnecessary database connections
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
            //If button is set to 'save' change the text to an input field with the value of
            // the previous text
            $(this).html("Save");
            var val = $("#showText").html();
            $("#showText").html("<input class='inpTextBig' type='text' value='"+val+"'>");
        } else {
            //If the button is set to 'save' change the input field to plain text
            $(this).html("Edit");
            var val = $("#showText input").val();
            $("#showText").html(val);

            //If the value changed, update it in the database. Only do it than to prevent
            // unnecessary database connections
            if (val !== data[0][1]) {
                updateDB("UPDATE Homepage SET maintext='"+val+"';");
                data[0][1] = val;
            }
        }
    });
}
