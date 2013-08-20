<?
include "includes/functions.php";

$title = "Big Red Clarinets";
$content = "Crafted with love using PHP, MySQL, various Jquery plugins (codemirrror, jQueryTree, markitup), css frameworks (formee), and HTML.";

$content = pageify($content, $title);

include "template.php";
?>