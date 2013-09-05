<?php
include "includes/functions.php";

$title = "Photos";
$content = "Photo Gallery currently under construction ... ";

$content = pageify($content, $title);

include "template.php";
?>