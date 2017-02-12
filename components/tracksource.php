<?
if((g("track-user") == 1)and(!isset($_GET['ajax']))){
    cms_session_start();
    if(!isset($_SESSION['referer']))
	$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
}
?>