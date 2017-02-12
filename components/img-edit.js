$(document).ready(function () {

    setTimeout(function () {
        $("div").mouseenter(function () {
            $(this).children(".img-edit").parent().addClass("hover-border");
        });
        $("div").mouseleave(function () {
            $(this).children(".img-edit").parent().removeClass("hover-border");
        });
        $("div.img-edit").click(function (ev) {


            if (typeof($.fancybox) !== "undefined")
                $.fancybox.close();

            var name = $(this).attr("name");
            var folder = $(this).attr("folder");
            var w = $(this).attr("w");
            var h = $(this).attr("h");
            var desc = $(this).attr("desc");
            var orig = $(this).attr("save-orig");
            $("div#img-edit-footer-dialog input[name=name]").val(name);
            $("div#img-edit-footer-dialog input[name=folder]").val(folder);
            $("div#img-edit-footer-dialog input[name=w]").val(w);
            $("div#img-edit-footer-dialog input[name=h]").val(h);
            $("div#img-edit-footer-dialog input[name=desc]").val(desc);
            $("div#img-edit-footer-dialog input[name=save-orig]").val(orig);
            imgEditDisplayGallery();

            return false;
        });

        function imgEditDisplayGallery() {
            $("div#img-edit-footer-dialog").scrollTop(0);
            var name = $("div#img-edit-footer-dialog input[name=name]").val();
            var folder = $("div#img-edit-footer-dialog input[name=folder]").val();
            var desc = $("div#img-edit-footer-dialog input[name=desc]").val();
            $("div#img-edit-footer-dialog .ajax-content").load("?ajax&img-edit&name=" + name + "&folder=" + folder, function () {
                // галарея загруженных
                $("div#img-edit-footer-dialog .ajax-content img").click(function () {
                    $("div#img-edit-footer-dialog input[name=img-edit-newval]").val($(this).attr("src"));
                    $("div#img-edit-footer-dialog form").submit();
                });
            });
            var w = parseInt($("div#img-edit-footer-dialog input[name=w]").val()) + 20;
            var winw = $(window).width() - 50;
            if (w < winw)
                w = Math.floor(winw / w) * w + 60;
            $("div#img-edit-footer-dialog").dialog({
                width: w,
                height: $(window).height() * 0.95,
                title: desc,
                modal: true,
                buttons: [
                    {
                        text: "Загрузить", click: function () {
                        imgUploadDialog(
                            $("div#img-edit-footer-dialog input[name=w]").val(),
                            $("div#img-edit-footer-dialog input[name=h]").val(),
                            $("div#img-edit-footer-dialog input[name=folder]").val(),
                            $("div#img-edit-footer-dialog input[name=save-orig]").val(),
                            imgEditDisplayGallery
                        );
                    }
                    },
                    {
                        text: "Убрать", click: function () {
                        $("div#img-edit-footer-dialog input[name=img-edit-newval]").val("");
                        $("div#img-edit-footer-dialog form").submit();
                    }
                    },
                    {
                        text: "Отмена", click: function () {
                        $(this).dialog("close");
                    }
                    }
                ]
            });
        };

    }, 1000);
});
