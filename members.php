<?php
include "includes/functions.php";

$title = "Members";

$content .= "<div><em class='formee-req'>*</em> = section leader</div>";

$query = "SELECT * FROM q_users WHERE u_isactive='1' ORDER BY u_classof";


db_connect();
$content .= db_query($query, "process_user");
db_close();

$content = pageify($content, $title);

include "template.php";
?>