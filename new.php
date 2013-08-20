<?
	include "includes/functions.php";

	if (isset($_POST['user']) && isset($_GET['user'])){
		$query = "INSERT INTO q_users ";
		
		$keys = Array();
		$values = Array();

		array_push($keys, "u_id");
		array_push($values, "NULL");

		array_push($keys, "u_isactive");
		array_push($values, "1");

		foreach($_POST as $key => $value) {
			if (strcmp($key, "user") != 0){	// dont want to insert button input
				array_push($keys, $key);
				array_push($values, "'" . clean($value) . "'");
			}
		}

		$query .= "(" . implode(",", $keys) . ")";
		$query .= " VALUES ";
		$query .= "(" . implode(",", $values) . ")";

		db_connect();
		db_query_nr($query);
		db_close();
		
		header("location:members.php");
	}

	if (isset($_POST['blog']) || isset($_GET['blog'])){
		
		$blog_title = clean($_POST['title']);
		$blog_content = clean($_POST['entry']);
		
		$query = "INSERT INTO q_blog VALUES(NULL, '$blog_title', '$blog_content', CURRENT_TIMESTAMP, 1)";
		db_connect();
		db_query_nr($query);
		db_close();
		
		header("location:admin.php?OK");
	}

	else if (isset($_POST['photo']) || isset($_GET['photo'])){
		
		$content = "<div class='title'>Choose a Thumbnail</div>";
		error_reporting (E_ALL ^ E_NOTICE);
		session_start(); //Do not remove this
		//only assign a new timestamp if the session variable is empty
		if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0){
		    $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
			$_SESSION['user_file_ext']= "";
		}
		#########################################################################################################
		# CONSTANTS																								#
		# You can alter the options below																		#
		#########################################################################################################
		$upload_dir = "uploads_full"; 				// The directory for the images to be saved in
		$thumb_dir = "uploads_thumb";
		$upload_path = $upload_dir."/";				// The path to where the image will be saved
		$thumb_path = $thumb_dir."/";
		$large_image_prefix = "resize_"; 			// The prefix name to large image
		$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
		$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
		$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
		$max_file = "1"; 							// Maximum file size in MB
		$max_width = "500";							// Max width allowed for the large image
		$thumb_width = "120";						// Width of thumbnail image
		$thumb_height = "120";						// Height of thumbnail image
		// Only one of these image types should be allowed for upload
		$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
		$allowed_image_ext = array_unique($allowed_image_types); // do not change this
		$image_ext = "";	// initialise variable, do not change this.
		foreach ($allowed_image_ext as $mime_type => $ext) {
		    $image_ext.= strtoupper($ext)." ";
		}
		
		//Image Locations
		$large_image_location = $upload_path.$large_image_name.$_SESSION['user_file_ext'];
		$thumb_image_location = $thumb_dir.$thumb_image_name.$_SESSION['user_file_ext'];
		
		//Create the upload directory with the right permissions if it doesn't exist
		if(!is_dir($upload_dir)){
			mkdir($upload_dir, 0777);
			chmod($upload_dir, 0777);
		}
		
		//Check to see if any images with the same name already exist
		if (file_exists($large_image_location)){
			if(file_exists($thumb_image_location)){
				$thumb_photo_exists = "<img src=\"".$thumb_path.$thumb_image_name.$_SESSION['user_file_ext']."\" alt=\"Thumbnail Image\"/>";
			}else{
				$thumb_photo_exists = "";
			}
		   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name.$_SESSION['user_file_ext']."\" alt=\"Large Image\"/>";
		} else {
		   	$large_photo_exists = "";
			$thumb_photo_exists = "";
		}
		
		
		if (isset($_POST["upload"])) { 
			//Get the file information
			$userfile_name = $_FILES['image']['name'];
			$userfile_tmp = $_FILES['image']['tmp_name'];
			$userfile_size = $_FILES['image']['size'];
			$userfile_type = $_FILES['image']['type'];
			$filename = basename($_FILES['image']['name']);
			
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			
			//Only process if the file is a JPG, PNG or GIF and below the allowed limit
			if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
				
				foreach ($allowed_image_types as $mime_type => $ext) {
					//loop through the specified image types and if they match the extension then break out
					//everything is ok so go and check file size
					if($file_ext==$ext && $userfile_type==$mime_type){
						$error = "";
						break;
					}else{
						$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
					}
				}
				//check if the file size is above the allowed limit
				if ($userfile_size > ($max_file*1048576)) {
					$error.= "Images must be under ".$max_file."MB in size";
				}
				
			}else{
				$error= "Select an image for upload";
			}
			//Everything is ok, so we can upload the image.
			if (strlen($error)==0){
				
				if (isset($_FILES['image']['name'])){
					//this file could now has an unknown file extension (we hope it's one of the ones set above!)
					$large_image_location = $large_image_location.".".$file_ext;
					$thumb_image_location = $thumb_image_location.".".$file_ext;
					
					//put the file ext in the session so we know what file to look for once its uploaded
					$_SESSION['user_file_ext']=".".$file_ext;
					
					move_uploaded_file($userfile_tmp, $large_image_location);
					chmod($large_image_location, 0777);
					
					$width = getWidth($large_image_location);
					$height = getHeight($large_image_location);
					//Scale the image if it is greater than the width set above
					if ($width > $max_width){
						$scale = $max_width/$width;
						$uploaded = resizeImage($large_image_location,$width,$height,$scale);
					}else{
						$scale = 1;
						$uploaded = resizeImage($large_image_location,$width,$height,$scale);
					}
					//Delete the thumbnail file so the user can create a new one
					if (file_exists($thumb_image_location)) {
						unlink($thumb_image_location);
					}
				}
				//Refresh the page to show the new uploaded image
				header("location:".$_SERVER["PHP_SELF"]."?photo");
				exit();
			}
		}
			
		// process second round photo upload (after cropping is done)
		if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) {
			//Get the new coordinates to crop the image.
			$x1 = $_POST["x1"];
			$y1 = $_POST["y1"];
			$x2 = $_POST["x2"];
			$y2 = $_POST["y2"];
			$w = $_POST["w"];
			$h = $_POST["h"];
			//Scale the image to the thumb_width set above
			$scale = $thumb_width/$w;
			$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
			//Reload the page again to view the thumbnail
			
			$query = "INSERT INTO q_photo VALUES(NULL,'$thumb_image_location', '$large_image_location','".
				clean($_POST['catpion'])."', CURRENT_TIMESTAMP)";
			
			db_connect();
			db_query_nr($query);
			db_close();
			
			header("location:admin.php");
			exit();
		}
		
		// delete
		if ($_GET['a']=="delete" && strlen($_GET['t'])>0){
		//get the file locations 
			$large_image_location = $upload_path.$large_image_prefix.$_GET['t'];
			$thumb_image_location = $thumb_path.$thumb_image_prefix.$_GET['t'];
			if (file_exists($large_image_location)) {
				unlink($large_image_location);
			}
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
			header("location:".$_SERVER["PHP_SELF"]);
			exit(); 
		}
		
		if(strlen($error)>0){
			$content = "<div class='title'>Error!</div> ".$error;
		} else {
		
		if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
			die ("Technical Difficulty. Please contact us.");
		} else {
			//Only display the javacript if an image has been uploaded
			if(strlen($large_photo_exists)>0){
				$current_large_image_width = getWidth($large_image_location);
				$current_large_image_height = getHeight($large_image_location);
			
				$v = $thumb_height/$thumb_width;
				
				$content .= "
				<script type='text/javascript'>
				function preview(img, selection) { 
					var scaleX = $thumb_width / selection.width; 
					var scaleY = $thumb_height / selection.height; 
					
					$('#thumbnail + div > img').css({ 
						width: Math.round(scaleX * $current_large_image_width) + 'px', 
						height: Math.round(scaleY * $current_large_image_height) + 'px',
						marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
						marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
					});
					$('#x1').val(selection.x1);
					$('#y1').val(selection.y1);
					$('#x2').val(selection.x2);
					$('#y2').val(selection.y2);
					$('#w').val(selection.width);
					$('#h').val(selection.height);
				} 
				
				$(document).ready(function () { 
					$('#save_thumb').click(function() {
						var x1 = $('#x1').val();
						var y1 = $('#y1').val();
						var x2 = $('#x2').val();
						var y2 = $('#y2').val();
						var w = $('#w').val();
						var h = $('#h').val();
						if(x1==\"\" || y1==\"\" || x2==\"\" || y2==\"\" || w==\"\" || h==\"\"){
							alert(\"You must make a selection first\");
							return false;
						}else{
							return true;
						}
					});
				}); 
				
				$(window).load(function () { 
					$('#thumbnail').imgAreaSelect({ aspectRatio: '1:". $thumb_height/$thumb_width ."', onSelectChange: preview }); 
				});
				</script>";
				
				}
				
				$content .= '
					<script type="text/javascript" src="scripts/jquery.imgareaselect.min.js"></script>
					
					<div class="info_inner">
						Please crop the big image to create your own profile picture 
						(shown on the right). To crop, click on the photo and drag. 
						When you are done, please click the submit button.
					
					
					<form name="thumbnail" action="'.$_SERVER["PHP_SELF"].'?photo" method="post">
						<input type="hidden" name="x1" value="" id="x1" />
						<input type="hidden" name="y1" value="" id="y1" />
						<input type="hidden" name="x2" value="" id="x2" />
						<input type="hidden" name="y2" value="" id="y2" />
						<input type="hidden" name="w" value="" id="w" />
						<input type="hidden" name="h" value="" id="h" /><br />
						<input type="hidden" name="caption" value="'.(isset($_POST['caption'])?$_POST['caption']:"").'" />
						<input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
					</form><br />
					
					<img src="'.$upload_path.$large_image_name.$_SESSION['user_file_ext'].'" style="margin-left: 20px;" id="thumbnail" alt="Create Thumbnail" />
					<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:'.$thumb_width.'px; height:'.$thumb_height.'px;">
						<img src="'.$upload_path.$large_image_name.$_SESSION['user_file_ext'].'" style="position: relative;" alt="Thumbnail Preview" />
					</div>
					</div>
				';
				
				$content .= isset($error)?"Error: ".$error:"";
			} 
		}
	}

	include "template.php";
?>