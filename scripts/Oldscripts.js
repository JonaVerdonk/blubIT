//Old Method //Hold and leave//
//HOLD event
var timeoutId;      //Id of timer
var CallObj = null; //Id of calling object
var Move = false;   //Curently in move mode?
var selectedOptionMove = null; //Selectedmovement

//Enable if mouse is down for 1 s
$('.content-body').on('mousedown', function() {
    //Enable movemode
    CallObj = this; //Called opject
    timeoutId = setTimeout(MoveMode, 1000); //Timer
}).on('mouseleave mouseup', function() { //Disable if left up mouse up
  if(Move){
    //Gridarea
    gridarea = $(this).css("grid-area");
    console.log(gridarea);
    //Get new area string
    switch(selectedOptionMove){
      case "cmsMove-top":     var gridareaVal = parseInt(getChar(gridarea, 0)) - 1; var newArea = replaceChar(gridarea, 0, gridareaVal); break;
      case "cmsMove-right":   var gridareaVal = parseInt(getChar(gridarea, 4)) + 1; var newArea = replaceChar(gridarea, 4, gridareaVal); break;
      case "cmsMove-left":    var gridareaVal = parseInt(getChar(gridarea, 4)) - 1; var newArea = replaceChar(gridarea, 4, gridareaVal); break;
      case "cmsMove-bottom":  var gridareaVal = parseInt(getChar(gridarea, 0)) + 1; var newArea = replaceChar(gridarea, 0, gridareaVal); break;
    }
    console.log(newArea);
    //USe new area string 3 / 1 / span 2 / span 12
    $(this).css("grid-area",newArea);
    //End move
    MoveMode();
  }
  CallObj = null;               //Nothing calls anymore
  clearTimeout(timeoutId);      //Clear timer
});

$(document).on("mouseenter", ".cmsMoveItem", function() {
  // hover starts code here
  selectedOptionMove = this.id;
  console.log(selectedOptionMove);
});


function MoveMode(){
  console.log(Move);
  if(Move){
    //Currently moving objecgt // Ending movement
    $('.CMSMovetool').remove();
    $(CallObj).css("background-color", "");
  }else{
    //Get current location
    loc = [getChar($(CallObj).css("grid-area"), 4),getChar($(CallObj).css("grid-area"), 0)]; //x,y
    //Not moving object // Beginning to move
    $(CallObj).append("<div class = 'CMSMovetool'><p id='cmsMove-top' class='cmsMoveItem'>&#9650;</p><p id='cmsMove-right' class='cmsMoveItem'>&#9654;</p><p id='cmsMove-bottom' class='cmsMoveItem'>&#9660;</p><p id='cmsMove-left' class='cmsMoveItem'>&#9664;</p><p>current location : (" + loc[0] + "," + loc[1] + ")</p></div>");
    $(CallObj).css("background-color", "gray");
  }
  // Always happens //
  Move = !Move;
  console.log(Move);
}
});











///////////////////////////CSS

.CMSMovetool{
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.1);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 200;
}
.CMSMovetool p:hover{
  background: yellow !important;
}
.CMSMovetool p{
  position: absolute;
  background: #9affe08c;
  border: 10px solid #7adbfd4a;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  z-index: 100;
}
.CMSMovetool p:first-child{
  top: 0;
  left: 0;
  width: 100%;
  height: 25%;
  text-align: center;
}
.CMSMovetool p:nth-child(2){
  /* Size */
  height: 50%;
  width: 25%;

  /*Position*/
  top: 25%;
  right: 0;

  /*Alignment*/
  text-align: right;


  /* Background and border*/
   background: #7adbfd8c;
  border: 10px solid #7adbfd4a;
}

.CMSMovetool p:nth-child(3){
  height: 25%;
  bottom: 0;
  left: 0;
  width: 100%;
  text-align: center;
}

.CMSMovetool p:nth-child(4){
  height: 50%;
  width: 25%;
  top: 25%;
  left: 0;
  text-align: left;
    background: #7adbfd8c;
  border: 10px solid #7adbfd4a;
}
