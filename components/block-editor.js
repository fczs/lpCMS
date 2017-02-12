$(document).ready(function (){
    $("div.block-editor-plank")
	.click(function(){
	    var name=$(this).attr("name");
	    $("div.block."+name)
		.toggleClass("active")
		.toggleClass("hidden");
	    $(this).children(".desc").load("/?ajax&toggle&block-editor="+name);
	})
	.each(function (ind, item){
	    $(item).children(".desc").load("/?ajax&block-editor="+$(item).attr("name"));
	});
});