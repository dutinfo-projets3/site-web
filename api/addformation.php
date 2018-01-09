<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 09/01/2018
 * Time: 15:16
 */

require_once "../autoload.inc.php";

if(empty($_POST['nomFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']){
	http_response_code(401);
	return;
}
try {
	$id = Formation::addFormation($_POST['nomFormation']);
	header("Content-type: application/json");
	echo json_encode(array("id" => $id));
}catch (Exception $e) {
	http_response_code(400);

}