<?
	include "includes/functions.php";
	
	if (isset($_POST['submit'])){
		$path = $_SESSION['file'];
		$content = stripslashes($_POST['file_editor']);
		
		$fh = fopen($path, 'w');
		fwrite($fh, $content);
		fclose($fh);
		
		echo 1;
	}
?>