<?php
include("config.php");

function get_temp_dir()
{
    return sys_get_temp_dir();
}

if (!function_exists('getimagesizefromstring')) {
    function getimagesizefromstring($arg)
    {
        $name = get_temp_dir() . "/" . md5($arg);
        file_put_contents($name, $arg);
        $retval = getimagesize($name);
        unlink($name);
        return $retval;
    }
}

$path = "data/" . get_host();
$fp = fopen($path . "/vars.php", "r");

try {
    flock($fp, LOCK_SH);
    include($path . "/vars.php");
    flock($fp, LOCK_UN);
    fclose($fp);
} catch (Exception $e) {
};

if (!isset($ok) or ($ok != 1))
    include($path . "/vars-backup.php");

$last_key = ""; // last queried key
$components_css = array();
$components_js = array();
$footer_callbacks = array();
$bodystart_callbacks = array();

$exposed_vars = array();

if (isset($_GET['editor']))
    req_auth();

if (isset($_GET['logout'])) {
    cms_session_start();
    $_SESSION['login-password'] = '';
}

function req_auth()
{
    if (!check_auth()) {
        echo '<html><head><meta charset="utf-8"></head><body><form method="POST"><input type="password" name="login-password" /><input type="submit" value="Вход"></form></body></html>';
        exit;
    }
}


function check_auth()
{
    $pass = g("password", false, false);
    if ($pass == "")
        return true;

    cms_session_start();
    if (isset($_POST['login-password'])) {
        $_SESSION['login-password'] = $_POST['login-password'];
    }

    if (!isset($_SESSION['login-password']))
        return false;

    return ($_SESSION['login-password'] == $pass);
}

function cms_session_start()
{
    if (!isset($_SESSION['started']))
        session_start();
    $_SESSION['started'] = 1;
}

function components()
{
    foreach (scandir("components") as $name) {
        if (preg_match("/\.php$/", $name))
            if ($name == 'countdown.php' || $name == 'slides.php' || $name == 'yacounter.php')
                continue;
            else
                include("components/$name");
    }
}

function gi($key, $path, $width, $height, $hint = "Изменить картинку")
{
    img_edit($key, $path, $width, $height, $hint, "orig.jpg");
    echo '<img src="' . g($key) . '" />';
}

function gf($key, $path, $width, $height, $hint = "Изменить картинку")
{
    img_edit($key, $path, $width, $height, $hint, "orig.jpg");
    echo '<a href="' . g($key) . 'orig.jpg" class="fancybox" data-fancybox-group="gr' . $path . '"><img src="' . g($key) . '" /></a>';
}

function cms_bodystart()
{
    global $bodystart_callbacks;
    foreach ($bodystart_callbacks as $name) {
        eval("$name();");
    }
}

function addbodystart($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $bodystart_callbacks;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $bodystart_callbacks))
        $bodystart_callbacks[] = $arg;
}

function add_footer_js()
{
    global $footer_js;
    foreach ($footer_js as $js) {
        echo "<script src=\"$js\" type=\"text/javascript\"></script>\r\n";
    }
}

function add_footer_css()
{
    global $footer_css;
    foreach ($footer_css as $css) {
        echo "<link href=\"$css\" rel=\"stylesheet\" type=\"text/css\" />\r\n";
    }
}

function cms_footer()
{
    global $footer_callbacks, $exposed_vars, $components_js;
    foreach ($components_js as $js) {
        echo "<script src=\"$js\" type=\"text/javascript\"></script>\r\n";
    }
    if (is_editor())
        echo "<script> var exposedVars = " . json_encode($exposed_vars) . "; </script>\r\n";
    foreach ($footer_callbacks as $name) {
        eval("$name();");
    }
}

function addfooterjs($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $footer_js;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $footer_js))
        $footer_js[] = $arg;
}

function addfooter($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $footer_callbacks;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $footer_callbacks))
        $footer_callbacks[] = $arg;
}

function addjs($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $components_css, $components_js;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $components_js))
        $components_js[] = $arg;
}

function addcss($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $components_css, $components_js;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $components_css))
        $components_css[] = $arg;
}

function addfootercss($arg, $arModes = array("editor"))
{
    if ($arModes == "any")
        $arModes = array("view", "editor");

    global $footer_css;
    $mode = is_editor() ? "editor" : "view";
    if (in_array($mode, $arModes) and !in_array($arg, $footer_css))
        $footer_css[] = $arg;
}

function cms_header()
{
    global $components_css;

    foreach ($components_css as $css) {
        echo "<link href=\"$css\" rel=\"stylesheet\" type=\"text/css\" />\r\n";
    }
}

function is_editor()
{
    return isset($_GET['editor']);
}

function get_host()
{
    $host = strtolower($_SERVER['HTTP_HOST']);
    if (preg_match("/^www\./", $host))
        $host = substr($host, 4);
    return $host;
}

function copy_site($from, $to)
{
    $root = $_SERVER['DOCUMENT_ROOT'];
    system("cd $root; cp -r data/$from data/$to");
#    mysql_query("insert into cms_data select option_key, '$to', option_value from cms_data where host='$from'");
}

function random_site($from, $domain = 'justlp.ru')
{
    $dest = time() . "." . $domain;
    copy_site($from, $dest);
    return $dest;
}

function gl($key, $hint)
{
    echo g($key);
    regular_text_field($key, $hint);
}

function glx($key, $hint)
{
    echo g($key, true, false);
    regular_text_field($key, $hint);
}

function grx($key, $hint)
{
    regular_text_field($key, $hint);
    echo g($key, true, false);
}


function gr($key, $hint)
{
    regular_text_field($key, $hint);
    echo g($key);
}

function getli($key = '', $escape = true)
{
    foreach (preg_split("/[\r\n]+/", g($key, true, $escape)) as $i) {
        if (substr($i, -10) == htmlspecialchars("<ul>")) echo "<li>" . substr($i, 0, -10) . "<ul>";
        elseif (substr($i, 0, 11) == htmlspecialchars("</ul>")) echo "</ul></li><li>" . substr($i, 11);
        else echo "<li>$i</li>\r\n";
    }
}

function g($key = '', $expose = true, $escape = true)
{
    global $last_key, $exposed_vars, $all_options;
    if ($key == '')
        $key = $last_key;
    $last_key = $key;

    if (!isset($all_options[$key])) {
        $all_options[$key] = "";
    }
    if ($expose)
        $exposed_vars[$key] = $all_options[$key];

    if ($escape)
        return htmlspecialchars($all_options[$key]);
    else
        return $all_options[$key];
}

function set_option($key, $newval, $force = false)
{

    global $all_options;
    if (!$force)
        req_auth();

    $all_options[$key] = $newval;

    $host = get_host();
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/$host/vars.php", '<? $all_options = ' . var_export($all_options, true) . '; $ok = 1; ?>', LOCK_EX);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/$host/vars-backup.php", '<? $all_options = ' . var_export($all_options, true) . '; $ok = 1; ?>', LOCK_EX);
}

function debug_print_r($var)
{
    ob_start();
    print_r($var);
    error_log(ob_get_flush());
}
