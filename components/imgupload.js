function imgUploadDialog(w, h, folder, saveOrig, callback) {
    $("#img-upload-footer-dialog .d-img-label").remove();
    $("#img-upload-footer-dialog .d-img-size").remove();

    $("#img-upload-footer-dialog").prepend('<label for="d-img-width" class="d-img-label">Ширина миниатюры, пикс.</label><input type="text" id="d-img-width" class="d-img-size" data-name="w" value="' + w + '"><label for="d-img-height" class="d-img-label">Высота миниатюры, пикс.</label><input type="text" id="d-img-height" class="d-img-size" data-name="h" value="' + h + '">');

    $(document).on('keypress', '.d-img-size', function(e) {
        if (!(e.which == 8 || e.which == 46 || (e.which > 47 && e.which < 58))) return false;
    });

    $(document).on('keyup', '.d-img-size', function() {
        var vSize = $(this).val();
        if(vSize.length) {
            if($(this).data('name') == "w")
                $("div#img-upload-footer-dialog input[name=w]").val(vSize);
            if($(this).data('name') == "h")
                $("div#img-upload-footer-dialog input[name=h]").val(vSize);
        }
    });

    $("div#img-upload-footer-dialog .note, div#img-upload-footer-dialog .jcrop-holder").remove();
    $("div#img-upload-footer-dialog input[name=h]").val(h);
    $("div#img-upload-footer-dialog input[name=w]").val(w);
    $("div#img-upload-footer-dialog input[name=folder]").val(folder);
    $("div#img-upload-footer-dialog input[name=save-orig]").val(saveOrig);
    $("div#img-upload-footer-dialog").dialog(
        {
            modal: true,
            title: 'Загрузить картинку',
            width: 400,
            height: 400,
            buttons: [
                {
                    text: "Сохранить", click: function () {
                    if ($("form[name=imguploadform] input[name=cx]").val() == "") {
                        $("div#img-upload-footer-dialog .note").css({'color': '#ff0000', 'font-size': '20px'});
                    }
                    else {
                        $("form[name=imguploadform] input[name=imgupload-save]").val(1);
                        $("form[name=imguploadform]").submit();
                        $(this).dialog("close");
                    }
                }
                },
                {
                    text: "Отмена", click: function () {
                    $(this).dialog("close");
                }
                }
            ]
        }
    );

    imgUploadInitForm();

    function imgUploadInitForm() {
        $("div#img-upload-footer-dialog input[name=imgupload]").change(function () {
            $("div#img-upload-footer-dialog input[name=imgupload]")
                .css("display", "none")
                .after('<img src="/images/ajax-loader-2.gif" />');
            $("form[name=imguploadform]").submit();
        });
        $("form[name=imguploadform] input[name=imgupload-save]").val(0);
        $("form[name=imguploadform]").ajaxForm(imgUploadAjaxForm);

    }

    function imgUploadAjaxForm(d) {
        if ($("div#img-upload-footer-dialog input[name=imgupload-save]").val() == 1)
            callback();

        $("div#img-upload-footer-dialog .ajax-content").html(d);
        imgUploadInitForm();

        if (($("div#img-upload-footer-dialog input[name=w]").val() == 0) && ($("div#img-upload-footer-dialog input[name=h]").val() == 0)) {
            $("div#img-upload-footer-dialog input[name=cx]").val(0);
            $("div#img-upload-footer-dialog input[name=cy]").val(0);
            $("div#img-upload-footer-dialog input[name=cw]").val($("div#img-upload-footer-dialog input[name=w]").val());
            $("div#img-upload-footer-dialog input[name=ch]").val($("div#img-upload-footer-dialog input[name=h]").val());
            return;
        }

        var ratio = -1;
        if (($("div#img-upload-footer-dialog input[name=w]").val() > 0) && ($("div#img-upload-footer-dialog input[name=h]").val() > 0)) {
            ratio = $("div#img-upload-footer-dialog input[name=w]").val() / $("div#img-upload-footer-dialog input[name=h]").val();
        }
        var ih = parseInt($("div#img-upload-footer-dialog .srcimg").attr("height")),
            iw = parseInt($("div#img-upload-footer-dialog .srcimg").attr("width"));
        var dh = ih + 200, dw = iw + 60;
        if (dw < 350)
            dw = 350;

        if (ih == 0)
            dh = 'auto';

        $("div#img-upload-footer-dialog").dialog("option", {height: dh, width: dw});

        if (ratio >= 0) {
            $("div#img-upload-footer-dialog .srcimg").Jcrop({
                aspectRatio: ratio,
                onChange: imgEditUpdateCoords,
                onSelect: imgEditUpdateCoords
            });
        }
        else {
            $("div#img-upload-footer-dialog .srcimg").Jcrop({
                onChange: imgEditUpdateCoords,
                onSelect: imgEditUpdateCoords
            });
        }


    }

    function imgEditUpdateCoords(c) {
        $("div#img-upload-footer-dialog input[name=cx]").val(c.x);
        $("div#img-upload-footer-dialog input[name=cy]").val(c.y);
        $("div#img-upload-footer-dialog input[name=cw]").val(c.w);
        $("div#img-upload-footer-dialog input[name=ch]").val(c.h);
    }
}
