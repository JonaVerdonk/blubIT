$(document).ready(function() {
    //The navbarButton is only visible when the screen is smaller
    // than a certain threshold. If the button is clicked, toggle
    // the visibility of the navbarlinks.
    $("#navbarButton").click(function() {
        $("#navbarLinks").toggle();
    });
});
