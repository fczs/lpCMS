<?

if(isset($_POST['dropdown-newval'])){
    set_option($_POST['name'], $_POST['dropdown-newval']);
}

addjs(JQUERY, "any");
addjs("components/dropdown-editor.js", array("editor"));
addcss("components/dropdown.css");


function dropdown($key = '', $description='', $arr = array()){

if(!is_editor())
    return; // этот компонент активен только в режиме редактирования

    global $last_key;
    if($key == '')
        $key = $last_key;
    $last_key = $key;

    $val = g($key);

    echo '<div class="dropdown-form" name="'.$key.'"><div class="pencil"></div><div class="desc">'.$description.'</div>';
    echo '<div class="form"><form method="POST"><select name="dropdown-newval">';
    foreach($arr as $k=>$i){
	$selected = ($k == $val) ? " selected" : "";
	echo "<option value=\"$k\"$selected>$i</option>";
    }
    echo '</select>';
    echo "<input type=\"hidden\" name=\"name\" value=\"$key\" />";
    echo '</form></div>';
    echo '</div>';
}

