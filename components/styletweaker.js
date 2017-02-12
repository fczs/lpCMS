$(document).ready(function (){

    $(".showbg-button").click(function (){
	$(".target").toggleClass("showbg");
	return false;
    });

    $.get($(".styletweaker-plank").attr("title")+"?"+Math.random(), function(d){
	$(".styletweaker-plank textarea").val(d);
	$(".styletweaker-plank textarea")[0].selectionStart = $(".styletweaker-plank form input[name=selectionstart]").val();
	$(".styletweaker-plank textarea")[0].selectionEnd = $(".styletweaker-plank form input[name=selectionstart]").val();
    });

    $(".styletweaker-plank form").submit(function (){
	$(".styletweaker-plank form input[name=selectionstart]").val($(".styletweaker-plank textarea")[0].selectionStart);
    });

    $(".styletweaker-plank .defcss").change(function (){
	var ta = $(".styletweaker-plank textarea");
	var val = ta.val();
	var newval = $(this).val();
	ta.val(val.substring(0, ta[0].selectionStart) + newval + val.substring(ta[0].selectionEnd, val.length));
    });


    $(".styletweaker-plank").dialog( { width: 500 } );
    $(".styletweaker-plank .px-slider").slider({
	    min: 0,
	    max: 500,
	    slide : function (event, ui){
		var ta = $(".styletweaker-plank textarea");
		var val = ta.val();
		var parse = cssParse(val, ta[0].selectionStart);
		if(!parse)
		    return false;

		var newval = ui.value/2;
		if(ui.value > 10)
		    newval = ui.value - 5;
		if(ui.value > 150)
		    newval = (ui.value - 150) * 2 + 145;
		if(ui.value > 300)
		    newval = (ui.value - 300) * 5 + 445;
		ta.val(val.substring(0, parse.valueStartOffset) + newval + val.substring(parse.valueEndOffset, val.length));
		ta[0].selectionStart = parse.valueStartOffset;
		ta[0].selectionEnd = parse.valueStartOffset;

		parse = cssParse(ta.val(), parse.valueStartOffset);
		var css = parse.operator.split(":");
		$(parse.selector).css(css[0], css[1]);
		$(parse.selector).css("outline", "rgb(255,128,80) dashed 1px");
	    }
    });

});

function cssParse(str, pos){
    var retval = {};
    var block = '', operator = '', valueStartOffset = 0;
    var blockmet = false, operatormet = false, valuemet = false;
    for(i = 0; i < str.length; i++){
	var c = str.substr(i,1);
	block = block + c;
	operator = operator + c;
	if(i == pos){
	    operatormet = true;
	    valuemet = true;
	    blockmet = true;
	}
	if(c == '}'){
	    if(blockmet)
		retval.block = block.trim();

	    blockmet = false; operatormet = false; valuemet = false;
	    block = ''; valueStartOffset = i;
	}
	if( (c == ';') || (c=='{') ){
	    if(operatormet){
		retval.operator = operator.trim();
		retval.operator = retval.operator.substr(0, retval.operator.length-1);
	    }
	    operator = '';
	    operatormet = false;
	}
	if( (c!='.')&& ((c<'0') || (c>'9')) ){
	    if(valuemet){
		retval.valueStartOffset = valueStartOffset;
		retval.valueEndOffset = i;
	    }
	    valueStartOffset = i+1;
	    valuemet = false;
	}
    }
    if(!retval.block)
	return false;
    if(!retval.operator)
	return false;
    if(retval.valueStartOffset == retval.valueEndOffset)
	return false;

    retval.selector = retval.block.split("{")[0].trim();
    return retval;
}