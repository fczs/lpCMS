<?

// ajax
if(isset($_GET['block-editor'])){
    if(!check_auth())
	die;

    $name = $_GET['block-editor'];
    $options = unserialize(g("options", false, false));
    $module = $options['modules'][$name];

    if(isset($_GET['toggle'])){
	$module['active'] = 1 - $module['active']; // toggle 0/1
	$options['modules'][$name] = $module;
	set_option("options", serialize($options));
    }

    echo "Блок '" . $module['desc'] ."' ";
    if($module['active'] == 0){
	echo "выключен и не отображается на Вашем сайте. Нажмите, чтобы включить.";
    }
    else
    {
	echo "включен. Нажмите, чтобы выключить.";
    }
}

// обычная обработка компонента

addcss("components/block-editor.css");
addjs(JQUERY);
addjs("components/block-editor.js");

function block_editor_plank($name){
    if(!is_editor())
	return; // этот компонент активен только в режиме редактирования
    echo "<div class=\"block-editor-plank\" name=\"$name\"><div class=\"icon\"></div><div class=\"desc\"></div></div>\r\n";
}

?>