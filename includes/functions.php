<?php
	include "identity.php";
	
	// session management
	if (session_id() == "") session_start();
	
	// set this or it complains
	date_default_timezone_set('America/New_York');
	
	// sanitize user input
	function clean($txt){
		return htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
	}
	
	function title($text){
		return "<div class='red title'>".$text."</div>";
	}
	
	function table($t){
		return "<table class='main_table'>".$t."</table>";
	}
	

	function photo_form(){
		return '<form class="formee" method="post" action="new.php" enctype="multipart/form-data">
			<fieldset>
				
				<div class="grid-12-12">
	                <label>File</label>
	               	<input name="image" size="50" type="file" /> 
		        </div>

				<div class="grid-12-12">
	                <label>Caption</label>
	               <input type="text" name="title" />
		        </div>

		        <input type="hidden" name="photo" value="photo" />
				
				<div class="grid-12-12">
					<input class="right" type="submit" name="upload" value="Upload" />
				</div>
			
			</fieldset>
		</form>';
	}
	
	function about_us_form(){
		return '<form class="formee" method="post" action="edit.php?about">
			<fieldset>
				<div class="grid-12-12">
		        	<label>Content <em class="formee-req">*</em></label>
		        	<textarea id="about_us" name="about_us" rows="" cols="" ></textarea>
		        </div>
		        
				<div class="grid-12-12">
					<input class="right" type="submit" title="Update" value="Update" />
				</div>
			</fieldset>
		</form>';
	}

	function pageify($content, $title = ""){
		$title = strlen($title) > 0 ? title($title) : "";
		return '<div id="page">
					<div id="content">
						' . $title . '
						<div class="post">' . $content . '
						</div>
					</div>
				</div>';
	}

	##########################################################################################################
	# IMAGE FUNCTIONS																						 #
	# You do not need to alter these functions																 #
	##########################################################################################################
	function resizeImage($image,$width,$height,$scale) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$image); 
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$image,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$image);  
				break;
	    }
		
		chmod($image, 0777);
		return $image;
	}
	//You do not need to alter these functions
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$thumb_image_name); 
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$thumb_image_name,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);  
				break;
	    }
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}
	//You do not need to alter these functions
	function getHeight($image) {
		$size = getimagesize($image);
		$height = $size[1];
		return $height;
	}
	//You do not need to alter these functions
	function getWidth($image) {
		$size = getimagesize($image);
		$width = $size[0];
		return $width;
	}
	
	/**
	 * Database Functions. Call sequence:
	 * 
	 * function process_stuff($a){
	 * 		...
	 * }
	 * 
	 * db_connect();
	 * db_execute($query, "process_stuff");
	 * db_close();
	 * 
	 */
	
	$myqli = null;
	$title = "";
	$content = "";
	
	/** Generates valid MySQL object */
    function db_connect(){
    	global $mysqli;
		$mysqli = new mysqli(identity::$host, identity::$username, identity::$password, identity::$db);
    }
    
	/** Queries the db with $query. Process each result with processing_function */
    function db_query($query, $processing_function){
    	global $mysqli;
		$c = "";
    	$r = $mysqli->query($query);
    	while ($a = $r->fetch_assoc()){
    		$c .= call_user_func($processing_function, $a);
    	}
    	
    	return $c;
    }
	
	function db_query_nr($query){
		global $mysqli;
		
		$state = 0;
		if ($mysqli == null){
			db_connect();
			$state = 1;
		}
		
		$mysqli->query($query);
		
		if ($state == 1) db_close();
	}
	
	/** Executes query, returns the first record as associative array */
	function db_query_one($query){
		global $mysqli;
		$r = $mysqli->query($query);
		return $r->fetch_assoc();
	}
    
	/** Closes the DB conenction */
    function db_close(){
    	global $mysqli;
    	$mysqli->close();	
    }
    
	/** Returns mysqli object */
    function db_mysqli(){
    	global $mysqli;
    	return $mysqli;
    }
	
	

?>