<?
	include "includes/functions.php";

	if (isset($_POST['user']) && isset($_GET['user'])){
		$query = "UPDATE q_users SET ";
		
		$conditions = Array();
		foreach($_POST as $key => $value) {
			if (strcmp($key, "user") != 0)	// dont want to update button input
				array_push($conditions, $key . "='" . clean($value) . "'");
		}

		$query .= implode(",", $conditions);
		$query .= " WHERE u_id='" . $_SESSION['uid'] . "'";

		db_connect();
		db_query_nr($query);
		db_close();
		
		header("location:user.php");

	}
