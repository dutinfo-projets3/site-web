<?php
require_once ("../autoload.inc.php");

function checkParam($id){
	return isset($_GET[$id]) && !empty($_GET[$id]);
}

// Si l'utilisateur n'est pas connecté on ne peut pas changer sa photo
if (!Utilisateur::isConnected()){
	http_response_code(401);
	return;
}

$util = Utilisateur::createFromSession();

// Si l'image est plus grande que 4 Mo c'est pas la peine
if ($_FILES["photo"]["size"] > 4000000){
	http_response_code(400);
	return;
}

$userfolder = $_SERVER["DOCUMENT_ROOT"] . "/users/";
if (!file_exists($userfolder)){
	mkdir($userfolder);
}

function uploadPic($file){
	$img = $_FILES["photo"]["tmp_name"];
	$mimect = mime_content_type($img);
	if ($mimect == "image/jpeg" || $mimect == "image/png"){
		list($w, $h) = getimagesize($img);
		$loadedImage = $mimect == "image/jpeg" ? imagecreatefromjpeg($img) : imagecreatefrompng($img);
		$savedImage  = imagecreatetruecolor(240, 300);
		imagecopyresampled($savedImage, $loadedImage, 0, 0, 0, 0, 240, 300, $w, $h);
		if (file_exists($file)){
			unlink($file);
		}
		imagejpeg($savedImage, $file);
		return true;
	} else { return false;}
}
$hasID = checkParam("name");

if ($hasID){
	if ($util->getUsername() == $_GET["name"] || $util->getUserType() == Utilisateur::TYPES["ADMINISTRATION"])
		uploadPic($userfolder . $_GET["name"] . ".jpg");
	else
		http_response_code(401);
	return;
} else {
	http_response_code(400);
	return;
}
