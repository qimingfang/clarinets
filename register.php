<?php
	include "includes/functions.php";

	if (isset($_GET['admin'])){
		$isadmin = generate_hidden("u_isadmin", "1");
		$isleader = generate_hidden("u_isleader", "1");
	} else {
		$isadmin = generate_hidden("u_isadmin", "0");
		$isleader = generate_hidden("u_isleader", "0");
	}

	function generate_hidden($name, $value){
		return "<input type='hidden' name='$name' value='$value' />";
	}

	$content .= title("New User");
	$content .= '
		<form class="formee" method="post" action="new.php?user">
			<div style="padding-bottom:10px;"><em class="formee-req">*</em> = cannot be changed and must be unique</div>
			<fieldset>' . $isadmin . $isleader . '
				<div class="grid-12-12">
	                <label>Email <em class="formee-req">*</em></label>
	               <input type="text" name="u_email" />
		        </div>
				<div class="grid-12-12">
	                <label>Name</label>
	               <input type="text" name="u_name" />
		        </div>
		        <div class="grid-12-12">
	                <label>Password</label>
	               <input type="password" name="u_pwd1" />
		        </div>
		        <div class="grid-12-12">
	                <label>Password Confirm</label>
	               <input type="password" name="u_pwd2" />
		        </div>
		        <div class="grid-12-12">
	                <label>Major</label>
	               <input type="text" name="u_major" />
		        </div>
		        <div class="grid-12-12">
	                <label>Hometown</label>
	               <input type="text" name="u_hometown" />
		        </div>
		        <div class="grid-12-12">
	                <label>Class Of</label>
	               <input type="text" name="u_classof" />
		        </div>
		        <div class="grid-12-12">
	                <label>Image (uploading not supported ... yet. Easiest is to go to facebook profile, right click profile picture -> copy image url -> paste here)</label>
	               <input type="text" name="u_avatar" />
		        </div>
				<div class="grid-12-12">
	                <label>Quote</label>
	               <input type="text" name="u_quote" />
		        </div>
		        <div class="grid-12-12">
	                <label>Previous Titles (Rank Leader, Bandstaph, etc)</label>
	               <input type="text" name="u_titles" />
		        </div>
		        <div class="grid-12-12">
		        	<label>Bio</label>
		        	<textarea id="blog_entry" name="u_bio" rows="" cols="" ></textarea>
		        </div>
		        
				<div class="grid-12-12">
					<input class="right" type="submit" name="user" title="Register" value="Register" />
				</div>
			
			</fieldset>
		</form>';

	$content = pageify($content);
	include "template.php";
?>