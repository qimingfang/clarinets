<?php
	include "includes/functions.php";

	function toggle($toggle){
		if ($toggle == 0) return 1;
		else return 0;

	}

	if (isset($_GET['makeadmin'])){
		$uid = $_GET['makeadmin'];

		$isadmin = $_GET['isadmin'];
		$isadmin = toggle($isadmin);

		$query = "UPDATE q_users SET u_isadmin='$isadmin' WHERE u_id = $uid";
		db_query_nr($query);
	}

	if (isset($_GET['activate'])){
		$uid = $_GET['activate'];
		$query = "UPDATE q_users SET u_isactive='1' WHERE u_id = $uid";
		db_query_nr($query);
	}

	if (isset($_GET['deactivate'])){
		$uid = $_GET['deactivate'];
		$query = "UPDATE q_users SET u_isactive='0' WHERE u_id = $uid";
		db_query_nr($query);
	}

	if (isset($_GET['delete'])){
		$uid = $_GET['delete'];
		$query = "DELETE FROM q_users WHERE u_id = $uid";
		db_query_nr($query);
	}

	if (isset($_GET['leader'])){
		$uid = $_GET['leader'];
		$isleader = toggle($_GET['isleader']);

		$query = "UPDATE q_users SET u_isleader='$isleader' WHERE u_id = $uid";
		db_query_nr($query);
	}

	header("location:user.php");