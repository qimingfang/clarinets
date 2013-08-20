<?php
	include "includes/functions.php";

	if (isset($_GET['photo']) || isset($_POST['photo'])){
		
		$photo = isset($_GET['photo'])?$_GET['photo']:$_POST['photo'];
		$id = clean($photo);
		
		$query = "DELETE FROM q_photo WHERE p_id = $id";
		db_connect();
		db_query_nr($query);
		db_close();
	}
	
	header("location:admin.php?ok");

?>