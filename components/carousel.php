<?

if(isset($_POST['carousel-slide-num-newval'])){
    set_option($_POST['name'], $_POST['carousel-slide-num-newval']);
}

addjs(JQUERY, "any");
addjs("components/carousel.js", array("editor"));
addjs("components/carousel-editor.js", array("editor"));
addcss("components/carousel.css");

function carousel_slide_num($key = '', $description='', $max=5){

if(!is_editor())
    return; // этот компонент активен только в режиме редактирования

    global $last_key;
    if($key == '')
        $key = $last_key;
    $last_key = $key;

    $val = g($key);

    echo '<div class="carousel-slide-num" name="'.$key.'"><div class="pencil"></div><div class="desc">'.$description.'</div>';
    echo '<div class="form"><form method="POST"><select name="carousel-slide-num-newval">';
    for($i = 1; $i <= $max; $i++){
	$selected = ($i == $val) ? " selected" : "";
	echo "<option value=\"$i\"$selected>$i</option>";
    }
    echo '</select>';
    echo "<input type=\"hidden\" name=\"name\" value=\"$key\" />";
    echo '</form></div>';
    echo '</div>';
}

