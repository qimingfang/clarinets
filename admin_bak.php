<?php
	include "includes/functions.php";
	
	if (isset($_SESSION['user_file_ext'])){
		unset($_SESSION['user_file_ext']);
		unset($_SESSION['random_key']);
	}
	
	function process_photos($a){
		return "<div class='photo_container'>".
			"<div class='shading'>".
				
				// edit form
				"<form method='post' action='edit.php?photo=".$a['p_id']."'>".
					"<input type='submit' name='submit' value='Edit' class='button' /></form>".
				
				// delete form
				"<form method='post' action='delete.php?photo=".$a['p_id']."'>".
					"<input type='submit' name='submit' value='Delete' class='button photo_delete' /></form>".
			"</div>".
			"<img alt='cover' class='galleryphoto' src='".
				($a['p_thumb'] == -1?identity::$noimg : $a['p_thumb'])."' />".
			"</div>";
	}
		
	if (isset($_GET['ok'])){
		
		$content .= "
			<script type='text/javascript'>
				$('#flash_msg').css({display : 'block', color : '#58FA58'});
				setTimeout(function(){
					$('#flash_msg').fadeOut(500);
				}, 500);
			</script>
		";
	}
		
	$content .= title("File System Manager");
	$content .= '
	<div id="file_preview">
		<form id="file_editor_form" class="formee" method="post" action="#">
			<textarea id="file_editor" name="file_editor"></textarea>
			<div class="grid-12-12">
				<span id="status"></span> <input id="file_editor_save" class="right" type="submit" title="Save" value="Save" />
			</div>
		</form>
	</div>';
		
	$content .= '<div id="file_tree"></div><br /><br />';
	
	if (identity::$blog){
		$content .= title("Blog Manager");
		$content .= blog_form();
	}
	
	if (identity::$gallery){
		$content .= title("Gallery Manager");
		$content .= photo_form();
		
		db_connect();
		$content .= table(db_query("SELECT * FROM q_photo", "process_photos"));
		db_close();
	}

	$content = pageify($content);
	
	include "template.php";
?>