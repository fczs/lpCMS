<?


addcss("components/edit-notes.css");

function note_above($text){
    if(!is_editor())
	return; // этот компонент активен только в режиме редактирования
    echo '<div class="note-above">'.$text.'</div>';
}

?>