<?

if(isset($_POST['regular-text-field-newval'])){
    set_option($_POST['name'], $_POST['regular-text-field-newval']);
}

addjs(JQUERY);
addcss("components/regular-text.css");
addjs("components/regular-text.js");
addjs(JQUERY);
addjs(JQUERYUI);
addcss(JQUERYUICSS);
addfooter("regular_text_footer");

function regular_text_field($key = '', $description=''){

    global $last_key;
    if($key == '')
	$key = $last_key;
    $last_key = $key;

    if(!is_editor())
	return; // этот компонент активен только в режиме редактирования

    $scrolltome = ( (isset($_POST['name'])) and ($_POST['name'] == $key) ) ? 'id="scrolltome" ' : '';
    echo '<div '.$scrolltome.'class="regular-text-field" name="'.$key.'" desc="'.$description.'" ><div class="pencil"></div><div class="desc">'.$description.'</div></div>';
}

function regular_text_footer(){
?>
<div id="regular-text-footer-dialog">
<form method="POST">
<input type="hidden" name="name" />
<textarea name="regular-text-field-newval">
</textarea>
</form>
</div>
<? } ?>