<?
addjs(JQUERY);
addjs(JQUERYUI);
addjs("components/styletweaker.js");
addcss(JQUERYUICSS);
addcss("components/styletweaker.css");

#addfooter("styletweaker_footer");

function styletweaker($name){
    if(!is_editor())
	return;
    if(isset($_POST['css-filename']) && ($_POST['css-filename'] == $name))
	file_put_contents($name, $_POST['newcss']);

    $sstart = (isset($_POST['selectionstart'])) ? $_POST['selectionstart'] : "0";

?>
<div class="styletweaker-plank" title="<?=$name?>
">
    <div class="px-slider"></div>
    <form method="POST">
	<textarea name="newcss" autocomplete="off"></textarea>
	<input type="hidden" name="css-filename" value="<?=$name?>" />
	<input type="hidden" name="selectionstart" value="<?=$sstart?>" />
	<input type="submit" value="save" />
	<select class="defcss" value="defcss">
	    <option value="" selected>Шаблоны</option>
	    <option value="position: absolute; top: 0px; left: 0px;">absolute</option>
	    <option value="height: 0px; width: 0px;">h-w</option>
	    <option value="display: inline-block; vertical-align: top; ">item</option>
	    <option value="margin: 0px 0px 0px 0px; ">margin</option>
	    <option value="padding: 0px 0px 0px 0px; ">padding</option>
	</select>
	<button class="showbg-button">showbg</button>
    </form>
</div>
<? }

?>