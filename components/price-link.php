<?

addcss("components/price-link.css");
addjs("components/price-link.js");

    function price_link($fname, $inner){
	if(!is_editor()){
	    echo '<a href="data/'.get_host() . '/uploads/' . $fname.'">' . $inner . '</a>';
	} else {

	    if(isset($_REQUEST['fname']) && ($_REQUEST['fname'] == $fname) && !empty($_FILES)){
		$local = $_SERVER['DOCUMENT_ROOT'] . '/data/' . get_host() . '/uploads/' . $fname;
		if(is_file($local))
		    unlink($local);
		move_uploaded_file($_FILES['price-link']['tmp_name'], $local);
	    }

	    echo <<<FORM
<form method="post" enctype="multipart/form-data" class="price-link">
<input type="file" name="price-link" />
<input type="hidden" name="fname" value="$fname" />
$inner
</form>
FORM;
	}
    }
?>