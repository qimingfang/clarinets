<?php
	include "includes/functions.php";

	$content .= title("New User");
	$content .= '
		<form class="formee" method="post" action="new.php?user">
			<div style="padding-bottom:10px;"><em class="formee-req">*</em> = cannot be changed and must be unique</div>
			<fieldset>
				<div class="grid-12-12">
	                <label>Email <em class="formee-req">*</em></label>
	               <input type="text" name="u_email" />
		        </div>
				<div class="grid-12-12">
	                <label>Name</label>
	               <input type="text" name="u_name" />
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