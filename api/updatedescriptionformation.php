<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 10/01/2018
 * Time: 22:51
 */
require_once "../autoload.inc.php";

if (empty($_POST['description'] && $_POST['duree'] && $_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(401);
	return;
}
try {
	Formation::addDescription($_POST['idFormation'], $_POST['description'], $_POST['duree']);
	http_response_code(200);
} catch (Exception $e) {
	http_response_code(400);
}