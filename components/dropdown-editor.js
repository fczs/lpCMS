$(document).ready(function (){
    $(".dropdown-form select").change(function (){
	$(this).parent().submit();
    });
    $(".dropdown-form select").click(function (){
	$(this).closest('.dropdown-form').addClass('fix');
    })
});
