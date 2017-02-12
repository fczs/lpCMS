<?

if(isset($_GET['newsite-hint'])){
    addjs(JQUERY);
    addcss("components/newsite.css");
    addbodystart("newsite_bodystart");
}


if(isset($_GET['newsite'])){
$template = 0 + $_GET['newsite'];
$template = "template" . $template . ".justlp.ru";
$url = random_site($template);
header("Location: http://$url/?editor&newsite-hint");
exit;
}

function newsite_bodystart(){
?>
<div id="newsite-hint">
Для Вас создан тестовый сайт. Вы можете наполнить его своими текстами и картинками и дать друзьям ссылку на него. Нажимайте на иконки, чтобы редактировать текст и изображения.<br><br>
<a target="_blank" href="http://<?=get_host()?>">Ссылка</a> на сайт в обычном режиме (без редактирования): <input type="text" value="http://<?=get_host()?>" /><br>
</div>
<?
}

?>
