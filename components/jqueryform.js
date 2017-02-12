$(document).ready(function (){
    $(".checkrequired").click(function (ev) {
        var valid = true;
        $(this).closest("form").find("input.invalid").removeClass("invalid");
        $(this).closest("form").find("input.required, textarea.required").each(function (i, e) {
            if ($(e).val() == "") {
                $(e).addClass("invalid invalid-by-required");
                valid = false;
            }
        });
        $(this).closest("form").find("input[data-regexp]").each(function (i, e) {
            var regexp = new RegExp($(e).data("regexp"));
            if (!regexp.test($(e).val())){
                $(e).addClass("invalid invalid-by-regexp");
                valid = false;
            }
        });
        if (valid && $(this).hasClass("dosubmit"))
            $(this).parent().submit();

        if (!valid){
            ev.stopPropagation();
            $($(this).closest("form").find(".invalid")[0]).focus();
        }
        return valid;
    });

    $("input.required").change(function (){
        $(this).removeClass("invalid");
    });

    $("form.ajaxform").each(function (i, e){
        (function(e) {
            $(e).ajaxForm(function (d){
                if($(e).hasClass("replace")){
                    var msg = $(e).attr("data-result-msg");
                    if(!msg)
                        msg = "Ваша заявка принята<br>Наш менеджер свяжется с Вами";
                    $(e).html('<div class="formresult">'+msg+'</div>');
                }
                $(e).addClass("sent");
            });
        })(e);
    });

});