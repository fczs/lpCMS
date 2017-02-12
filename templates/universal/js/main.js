$(function () {
    // validate modal form
    // clear all messages
    $.validator.messages.required = "";
    var baseErrorMessage = {
        email: {
            email: ""
        }
    };

    $('selector').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: baseErrorMessage.email
        }
    });

    $(document).on('click', 'selector', function (e) {
        var $form = $('selector'),
            data = $form.serializeObject();

        if (!$form.valid()) return false;

        $.post("/components/ajax/ajax-mail.php", data, function (response) {
            $('selector').html('<div class="success">' + response + '</div>');
        });

        e.preventDefault();
    });
});

// serialize array of form [name] fields
$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};