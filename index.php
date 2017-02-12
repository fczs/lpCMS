<?php

include("functions.php");

$host = get_host();

if(file_exists("index.options.php")) include("index.options.php");

components();

if(isset($_GET['ajax'])) exit;

$options = g("options", false, false);

if(strlen($options) < 5) die("Site not found");

$options = unserialize($options);
$template = $options['template'];
define('TEMPLATE_DIR', "templates/" . $template);

foreach($options['modules'] as $module => $mval)
{
    $active = $mval['active'] == 1 ? "active" : "hidden";

    if(!isset($mval['permanent'])) block_editor_plank($module);

    if(is_editor() or ($active == 'active'))
    {
        if(!isset($mval['permanent'])) echo "<div class=\"$module block $active\">\r\n";

        include("templates/$template/$module.php");

        if(!isset($mval['permanent'])) echo "</div>\r\n";
    }
}
