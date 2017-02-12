$(document).ready(function (){
    $(".carousel-vertical, .carousel-vertical li")
	.addClass("carousel-block")
	.scrollTop(0);

    setInterval(function (){
	var cv = $(".carousel-vertical");
	var mh = cv.children("ul").height();
	var st = cv.scrollTop();
	var height = cv.height();
	if(mh >= st+height*2)
	    cv.animate({scrollTop: st+height});
	else
	    cv.animate({scrollTop: 0});	
    }, 5000);
});
