<?
	include "includes/functions.php";
	
	//admin funciton
	function process_admin_user($user){
		$id = $user['u_id'];

		$active = $user['u_isactive'] ? "deactivate" : "activate";

		return "<tr><td>$id</td><td>" . $user['u_name']. "</td><td>" . $user['u_email'] . "</td><td>". 
			$user['u_isactive']. "</td><td>" . $user['u_isadmin'] . "</td>" .
			"<td> " . $user['u_isleader'] . "</td>" .
			"<td><a href='action.php?$active=$id'>$active</a></td>" . 
			"<td><a href='action.php?makeadmin=$id&isadmin=" . $user['u_isadmin'] . "''>Toggle</a></td>" .
			"<td><a href='action.php?leader=$id&isadmin=" . $user['u_isleader'] . "''>Toggle</a></td>" .
			"<td><a href='action.php?delete=$id' onclick='return confirm(\"Are you sure?\");'>DELETE</a></td>";
	}

	if (isset($_SESSION['user_file_ext'])){
		unset($_SESSION['user_file_ext']);
		unset($_SESSION['random_key']);
	}

	// flash notification
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

	$uid = $_SESSION['uid'];

	db_connect();
	$user = db_query_one("SELECT * FROM q_users WHERE u_id='$uid'");
	db_close();

	$content .= title("Edit Personal Info");
	$content .= '
		<form class="formee" method="post" action="edit.php?user">
			<fieldset>
				<div class="grid-12-12">
	                <label>Name</label>
	               <input type="text" name="u_name" value="' . $user["u_name"] . '" />
		        </div>
		        <div class="grid-12-12">
	                <label>Email</label>
	               <input type="text" name="u_email" value="' . $user["u_email"] . '" />
		        </div>
		        <div class="grid-12-12">
	                <label>Major</label>
	               <input type="text" name="u_major" value="' . $user["u_major"] . '" />
		        </div>
		        <div class="grid-12-12">
	                <label>Hometown</label>
	               <input type="text" name="u_hometown" value="' . $user["u_hometown"] . '" />
		        </div>
		        <div class="grid-12-12">
	                <label>Class Of</label>
	               <input type="text" name="u_classof" value="' . $user["u_classof"] . '" />
		        </div>
		        <div class="grid-12-12">
	                <label>Image (uploading not supported ... yet. Easiest is to go to facebook profile, right click profile picture -> copy image url -> paste here)</label>
	               <input type="text" name="u_avatar" value="' . $user["u_avatar"] . '" />
		        </div>
				<div class="grid-12-12">
	                <label>Quote</label>
	               <input type="text" name="u_quote" value="' . $user["u_quote"] . '" />
		        </div>
		        <div class="grid-12-12">
		        	<label>Bio</label>
		        	<textarea id="blog_entry" name="u_bio" rows="" cols="" >' . $user["u_bio"] . '</textarea>
		        </div>
		        
				<div class="grid-12-12">
					<input class="right" type="submit" name="user" title="Save" value="Save" />
				</div>
			
			</fieldset>
		</form>';
	
	if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']){
		
		$content .= title("File Manager (Admin Only)");
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

		$content .= title("User Manager (Admin Only)");

		$query = "SELECT * FROM q_users";
		
		$headers = Array("ID", "Name", "Email", "Is Active", "Is Admin", "Is Current Section Leader",  "(de)Activate", "Toggle Is-Admin", "Toggle Is-Leader", "Delete");
		db_connect();
		$content .= table("<tr><td>" . implode("</td><td>", $headers) . "</td></tr>" . db_query($query, "process_admin_user"));
		db_close();

	}

	$content = pageify($content);
	
	include "template.php";
?>