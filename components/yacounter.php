<?

addjs("components/yacounter.js", "any");

function yacounter($id){

if($id == "")
    return;

?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter<?=$id?> = new Ya.Metrika({id:<?=$id?>,
                    webvisor:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    ut:"noindex"});
	    w.yaCounterId = w.yaCounter<?=$id?>;

        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/<?=$id?>?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?
}
?>