$(document).ready(function(){
filterSelection("all");

function filterSelection(c) {
  switch(c){
    case "all": $(".column").css("display","block");$(".column").parent().css("padding",""); break;
    case "singlemode": $(".singlemode").css("display","block");$(".singlemode").parent().css("padding",""); $(".multimode").css("display","none");$(".multimode").parent().css("padding","0px"); break;
    case "multimode": $(".multimode").css("display","block"); $(".multimode").parent().css("padding","");$(".singlemode").css("display","none");$(".singlemode").parent().css("padding","0px"); break;
  }
}

$(document).on("click", "#all", function(){filterSelection("all")}).on("click", "#singlemode", function(){filterSelection("singlemode")}).on("click", "#multimode", function(){filterSelection("multimode")});

});
