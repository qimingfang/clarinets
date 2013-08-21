<?
include "includes/functions.php";

$title = "Photos";
$content = "To join us, please send an email to our current section leaders!";

$query = "SELECT * FROM q_users WHERE u_isactive='1' AND u_isleader='1'";
db_connect();
$content .= db_query($query, "process_user");
db_close();

$content = pageify($content, $title);

include "template.php";
?>