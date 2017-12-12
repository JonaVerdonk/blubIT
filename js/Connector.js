$(document).ready(function(){
filterSelection("all");

function filterSelection(c) {
  console.log("yellow");
  switch(c){
    case "all": $(".column").css("display","block"); break;
    case "singlemode": $(".singlemode").css("display","block"); $(".multimode").css("display","none"); break;
    case "multimode": $(".multimode").css("display","block"); $(".singlemode").css("display","block"); break;
  }
}

$(document).on("click", "#all", filterSelection("all")).on("click", "#singlemode", filterSelection("singlemode")).on("click", "#multimode", filterSelection("multimode"));

});
