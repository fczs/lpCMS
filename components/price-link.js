$(function (){
    $("form.price-link input[type=file]").change(function (){
	$(this).closest("form").submit();
    });
});
