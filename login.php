<?php
	include "includes/functions.php";

	if (isset($_SESSION['uid'])){
		header("location:user.php");
	}
	
	if (isset ($_POST['submit'])){
		if (!$_POST["email"] || !$_POST["password"]){
			$title = "Error";
			die("You need to provide a username and password! <a href='login.php'>Login</a>");
		} else {

			$email =  clean($_POST['email']);
			$password = clean($_POST['password']);
					
			$query = "
			SELECT *
			FROM q_users
			WHERE u_email = '$email'
			";
			
			db_connect();
			$arr = db_query_one($query);

			if (isset($arr['u_pwd']) && strcmp(hash('sha256', $password), $arr['u_pwd']) == 0){
				$_SESSION['uid'] = $arr['u_id'];
				$_SESSION['email'] = $arr['u_email'];
				$_SESSION['isadmin'] = $arr['u_isadmin'];

				$query = "UPDATE users SET u_lastlogin = CURRENT_TIMESTAMP WHERE u_id='".$arr['u_id']."'";
				db_query_nr($query);

				header("location:user.php");
			
			} else {
				unset($_SESSION['uid']);
				unset($_SESSION['email']);
				
				$title = "Error";
				die("Invalid Username or Password! <a href='login.php'>Login</a>");
			}
		}
	}

	if ($title == "" && $content == ""){
		$title = identity::$site_name." Login";
		$content = pageify(
			'<form method="post" action="login.php">
				<table>
					<tr><td>Email</td><td><input type="text" name="email" /></td></tr>
					<tr><td>Password</td><td><input type="password" name="password" /></td></tr>
					<tr><td colspan = "2"><input type="submit" name="submit" value="Login" /></td></tr>
				</table>
			</form>', 'Member Login');
	}
	
	include "template.php";
?>