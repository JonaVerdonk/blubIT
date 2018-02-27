$(document).ready(function(){
  var imgLeng = $(".reference-img").length;
  var x = 0;
  window.setInterval(function(){
    var windowwidth = window.innerWidth;
    var width = parseInt($(".reference-img").css("width"), 10);

    var amountOnScreen = Math.round(windowwidth / width);
    x += 0.001;
    var absSin = (Math.sin(x) + 1) / 2;
    $(".reference-img").css("right", absSin * width * (imgLeng - amountOnScreen + 0.5));
  }, 50);

});
