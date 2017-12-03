<?php
if (!isset($_GET['name']) || empty($_GET['name']) || strpos($_GET["name"], "..") || strpos($_GET["name"], "/")){
	http_response_code(400);
	return;
}

$file = "../users/" . $_GET['name'] . ".jpg";
header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($file));
readfile(file_exists($file) ? $file : "../users/default.jpg");
