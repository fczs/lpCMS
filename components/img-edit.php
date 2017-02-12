<?

if (isset($_POST['img-edit-newval'])) {
    set_option($_POST['name'], $_POST['img-edit-newval']);
}

if (isset($_GET['img-edit'])) {
    $folder = preg_replace("/[^a-z0-9\-]/", "0", $_GET['folder']);
    $files = array();

    $path = "/data/" . get_host() . "/" . $folder;
    foreach (scandir($_SERVER['DOCUMENT_ROOT'] . $path) as $file) {
        if (!preg_match("/[a-f0-9]{32}\.(jpg|png|gif)$/", $file))
            continue;
        $st = stat($_SERVER['DOCUMENT_ROOT'] . "$path/$file");
        $files[] = array("name" => "$path/$file", "timestamp" => $st[9]);
    }

    usort($files, 'sortfunc');

    foreach ($files as $key => $val) {
        $file = $val["name"];
        echo "<img class=\"selector\" src=\"$file\" />";
    }

}

function sortfunc($a, $b)
{
    return $a["timestamp"] < $b["timestamp"];
}

addjs(JQUERY);
addjs(JQUERYFORM);
addjs(JQUERYUI);
addjs("components/img-edit.js");
addjs("components/jcrop.min.js");

addcss(JQUERYUICSS);
addcss("components/jcrop.css");
addcss("components/img-edit.css");


addfooter("img_edit_footer");

function img_edit($key, $folder, $w, $h, $description, $save_orig = "")
{

    global $last_key;
    if ($key == '')
        $key = $last_key;
    $last_key = $key;

    if (!is_editor())
        return; // этот компонент активен только в режиме редактирования

    $scrolltome = ((isset($_POST['name'])) and ($_POST['name'] == $key)) ? 'id="scrolltome" ' : '';
    echo '<div ' . $scrolltome . 'class="img-edit" name="' . $key . '" folder="' . $folder . '" save-orig="' . $save_orig . '" w="' . $w . '" h="' . $h . '" desc="' . $description . '" ><div class="pencil"></div><div class="desc">' . $description . '</div></div>';
}

function img_edit_footer()
{
    ?>
    <div id="img-edit-footer-dialog">
        <form method="POST">
            <div class="ajax-content"></div>
            <div class="selected"></div>
            <div class="cropdialog"></div>
            <input type="hidden" name="h"/>
            <input type="hidden" name="w"/>
            <input type="hidden" name="name"/>
            <input type="hidden" name="desc"/>
            <input type="hidden" name="folder"/>
            <input type="hidden" name="save-orig"/>
            <input type="hidden" name="img-edit-newval"/>
        </form>
    </div>
<? } ?>