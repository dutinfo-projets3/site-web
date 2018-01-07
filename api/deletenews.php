<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 07/01/2018
 * Time: 11:53
 */
require_once "../autoload.inc.php";

if (empty($_POST['idNews'])
		&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(400);
	return;
}
$res = false;
try{
	$res = News::deleteNews($_POST['idNews']);
}catch (Exception $e){
	http_response_code(400);
}
$res ? http_response_code(200) : http_response_code(400);
