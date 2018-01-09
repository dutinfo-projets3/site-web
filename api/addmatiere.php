<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 09/01/2018
 * Time: 19:24
 */
require_once "../autoload.inc.php";

if(empty($_POST['nomMatiere'] && $_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']){
	http_response_code(401);
	return;
}
try {
	$id = Matiere::addMatiere($_POST['nomMatiere'], $_POST['idFormation']);
	header("Content-type: application/json");
	echo json_encode(array("id" => $id));
}catch (Exception $e) {
	var_dump($e);
	http_response_code(400);

}