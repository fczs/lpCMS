<?

if(isset($_POST['sortable_new_order'])){
    $order = $_POST['sortable_new_order'];
    set_option($order['subj'], serialize($order['order']));
}

function get_order_array($key, $size){
    $order = g($key, false, false);
    if($order != ""){
	$arr = unserialize($order);
	if(sizeof($arr) == $size)
	    return array_values($arr);
    }
    
    $retval = array();
    for($x = 1; $x <= $size; $x++){
	$retval[] = $x;
    }
    return $retval;
}

addjs("components/sortable.js");

?>
