<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 10/01/2018
 * Time: 23:08
 */
require_once("../autoload.inc.php");
if (empty($_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(401);
	return;
}
try {
	$formation = Formation::createFromID($_POST['idFormation']);
	header("Content-type: application/json");
	echo(json_encode(array('duree' => $formation->getDuree(), 'description' => ($formation->getDescription()))));

} catch (Exception $e) {
	http_response_code(400);
}