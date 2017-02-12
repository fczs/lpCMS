function setCookie(title, value, exp) {
    var expdate = new Date();
    expdate.setDate(expdate.getDate() + exp);
    document.cookie = title+'='+value+';expires='+expdate.toGMTString()+';path=/';
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ))
    return matches ? decodeURIComponent(matches[1]) : undefined 
}


$(document).ready(function(){

    // управление скроллингом
    $(document).scroll(function (){
	setCookie("scrolltop", $("html").scrollTop(), 30);
    });
    // вернуть скроллинг в позицию, которая была до перезагрузки
    var st = getCookie("scrolltop");
    $("html, body").scrollTop(st);

    $("div").mouseenter(function (){
	$(this).children(".regular-text-field").parent().addClass("text-hover-border");
    });
    $("div").mouseleave(function (){
	$(this).children(".regular-text-field").parent().removeClass("text-hover-border");
    });
    $("div.regular-text-field").click(function (ev){
	ev.preventDefault();
	var name = $(this).attr("name");
	$("div#regular-text-footer-dialog input[name=name]").val(name);
	$("div#regular-text-footer-dialog textarea").val(exposedVars[name]);
	$("div#regular-text-footer-dialog").dialog({
	    height: 400,
	    width: 600,
	    title: $(this).attr("desc"),
	    modal: true,
	    buttons: [
		 { text: "Сохранить", click: function() { $("div#regular-text-footer-dialog form").submit(); } },
		 { text: "Отмена", click: function() { $( this ).dialog( "close" ); } }
	     ]
	});
	if(typeof($.fancybox) !== "undefined")
	    $.fancybox.close();
	return false;
    });
});
