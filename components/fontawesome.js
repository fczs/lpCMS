$(function (){
        $("div.fontawesome-field").click(function (ev){
        ev.preventDefault();
        var name = $(this).attr("name");
	var val = exposedVars[name];
        $("div#fontawesome-footer-dialog input[name=name]").val(name);
        $("div#fontawesome-footer-dialog  input[name=fontawesome-field-newval]").val(val);
	$("div#fontawesome-footer-dialog i.fa").removeClass("active");
        if(val)
	    $("div#fontawesome-footer-dialog i.fa."+val).addClass("active");

        $("div#fontawesome-footer-dialog").dialog({
            height: 400,
            width: 600,
            title: $(this).attr("desc"),
            modal: true,
            buttons: [
                 { text: "Сохранить", click: function() { $("div#fontawesome-footer-dialog form").submit(); } },
                 { text: "Отмена", click: function() { $( this ).dialog( "close" ); } }
             ]
        });
        $("div#fontawesome-footer-dialog i.fa").click(function (){
	    var cl = $(this).data().cl;
	    $("div#fontawesome-footer-dialog input[name=fontawesome-field-newval]").val(cl);
	    $("div#fontawesome-footer-dialog i.fa").removeClass("active");
	    $(this).addClass("active");
	});
        if(typeof($.fancybox) !== "undefined")
            $.fancybox.close();
        return false;
    });

});
