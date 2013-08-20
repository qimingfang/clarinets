<?
include "includes/functions.php";

$title = "Members";

function process_user($arr){
	$name = $arr["u_name"];
	$major = $arr["u_major"];
	$classof = $arr["u_classof"];
	$hometown = $arr["u_hometown"];
	$bio = $arr["u_bio"];
	$picture =  strlen($arr["u_avatar"]) == 0 ? ("images/noimg.jpg") : $arr["u_avatar"];
	$quote = $arr["u_quote"];
	$email = $arr["u_email"];

	$ret = "";
	$ret .= "<div class='member'>";
	$ret .= "<div class='member-pic'><img src='" . $picture . "' alt='$name' /></div>";
	$ret .= "<div class='member-desc'>";
	$ret .= "<div class='member-name'><a href='mailto:$email'>$name</a> | Class of $classof | Major: $major | Hometown: $hometown</div>";
	$ret .= $bio;
	$ret .= "</div>";
	$ret .= "<div class='member-quote'>$quote</div>";
	$ret .= "</div>";

	return $ret;
}

$query = "SELECT * FROM q_users WHERE u_isactive='1'";
db_connect();
$content .= db_query($query, "process_user");
db_close();

$content = pageify($content, $title);

include "template.php";
?>