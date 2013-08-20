<?php
	include "includes/functions.php";
	
	if (isset($_GET['file'])){
		$_SESSION['file'] = $_GET['file'];
		$path = $_GET['file'];
		
		foreach (file($path) as $line){
			echo $line;
		}
	}
	
?>