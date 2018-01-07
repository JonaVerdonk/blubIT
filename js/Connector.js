// .ready zorgt ervoor dat de code wordt gedraaid zodra de DOM veilig is om te manipuleren //
$(document).ready(function(){
    filterSelection("all");
// functie die ervoor zorgt dat de radio buttons filteren //
    function filterSelection(c) {
// veranderd (c) zodra een radio button wordt in gedrukt //
        switch(c){
// filter om alle connectoren te laten zien //
            case "all":
                $(".column").css("display","block");
                $(".column").parent().css("padding","");
                break;
// filter om singlemode connectoren te laten zien //
            case "singlemode":
                $(".singlemode").css("display","block");
                $(".singlemode").parent().css("padding","");
                $(".multimode").css("display","none");
                $(".multimode").parent().css("padding","0px");
                break;
// filter om multimode connectoren te laten zien // 
            case "multimode":
                $(".multimode").css("display","block");
                $(".multimode").parent().css("padding","");
                $(".singlemode").css("display","none");
                $(".singlemode").parent().css("padding","0px");
                break;
        }
    }
// zorgt ervoor, als iemand op een radio button clickt de functie uit wordt gevoerd //
    $(document).on("click", "#all", function() {
        filterSelection("all");
    }).on("click", "#singlemode", function() {
        filterSelection("singlemode");
    }).on("click", "#multimode", function() {
        filterSelection("multimode");
    });

});
