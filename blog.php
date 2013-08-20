<?php
	include "includes/functions.php";
	
	function process_blog($a){
		return "
			<div class='blog_container'>
				<div class='blog_title'>" .
					$a['b_title'] .
				"</div>
				
				<div class='blog_content'>" .
					$a['b_text'] .
				"</div>
				
				
			</div>
		";
	}	
	
	$query = "SELECT b_title, b_text, MONTH(b_date) AS month, DAY(b_date) AS day FROM q_blog";
	db_connect();
	$content .= db_query($query, "process_blog");
	db_close();
	
	include "template.php";
?>