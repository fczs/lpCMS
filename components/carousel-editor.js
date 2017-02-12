$(document).ready(function (){
    $(".carousel-slide-num select").change(function (){
	$(this).parent().submit();
    });
});
