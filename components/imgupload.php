<?

if (isset($_POST['imgupload-save']) and ($_POST['imgupload-save'] == 1)) {
    $cx = $_POST['cx'];
    $cy = $_POST['cy'];
    $cw = $_POST['cw'];
    $ch = $_POST['ch'];
    $w = $_POST['w'];
    $h = $_POST['h'];
    $orig = $_POST['save-orig'];

    cms_session_start();

    $folder = preg_replace("/[^a-z0-9\-]/", "0", $_POST['folder']);
    $path = "/data/" . get_host() . "/" . $folder . '/' . $_SESSION['tempimg']['name'];

    if (($h == 0) && ($w == 0)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . $path, $_SESSION['tempimg']['data']);
    } else {

        if ($h == 0) {
            $ratio = $cw / $w;
            $h = $ch / $ratio;
        }

        if ($w == 0) {
            $ratio = $ch / $h;
            $w = $cw / $ratio;
        }

        $img_src = imagecreatefromstring($_SESSION['tempimg']['data']);
        $img_dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($img_dst, $img_src, 0, 0, $cx, $cy, $w, $h, $cw, $ch);
        imagejpeg($img_dst, $_SERVER['DOCUMENT_ROOT'] . $path, 95);

        if (strlen($orig) > 0)
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . $path . $orig, $_SESSION['tempimg']['data']);
    }

    imgupload_form();
}


if (isset($_GET['tempimg'])) {
    cms_session_start();
    $imgdata = $_SESSION['tempimg']['data'];
    $size = getimagesizefromstring($imgdata);
    header("Content-type: " . $size['mime']);
    echo $imgdata;
}

if (isset($_FILES['imgupload'])) {
    cms_session_start();
    $f = $_FILES['imgupload'];
    if (preg_match("/(\.(jpg|png|gif))$/i", $f['name'], $matches))
        $ext = strtolower($matches[1]);
    else
        $ext = ".jpg";

    $tf = md5($f['tmp_name'] . $f['name']) . "$ext";
    $tfpath = get_temp_dir() . "/" . $tf;
    $src = $f['tmp_name'];
    $size = getimagesize($src);
    if (($size[0] > 13000) or ($size[1] > 5000))
        system("convert -resize 13000x5000 $src $tfpath");
    else
        move_uploaded_file($src, $tfpath);

    $imgdata = file_get_contents($tfpath);
    $_SESSION['tempimg']['data'] = $imgdata;
    $_SESSION['tempimg']['name'] = $tf;
    $size = getimagesizefromstring($imgdata);
    unlink($tfpath);

    imgupload_form();
    echo '<div class="note">Выделите при помощи мыши нужную часть изображения</div>';
    echo '<img class="srcimg" ' . $size[3] . ' src="?ajax&tempimg&rand=' . time() . '" />';
}

addjs("components/imgupload.js");
addcss("components/imgupload.css");
addfooter("imgupload_footer");

function imgupload_footer()
{
    echo '<div id="img-upload-footer-dialog">' . "\r\n";
    imgupload_form();
    echo "</div>\r\n";
}

function imgupload_form()
{ ?>
    <div class="ajax-content">
        <form enctype="multipart/form-data" method="POST" name="imguploadform" action="?ajax">
            <input type="file" name="imgupload"/>
            <? foreach (array("h", "w", "ch", "cw", "cx", "cy", "folder", "imgupload-save", "save-orig") as $fname) {
                $val = isset($_POST[$fname]) ? $_POST[$fname] : "";
                echo '<input type="hidden" name="' . $fname . '" value="' . $val . '" />';
            }
            ?>
        </form>
    </div>
    <?
}

?>