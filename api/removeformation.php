<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 09/01/2018
 * Time: 17:22
 */

require_once "../autoload.inc.php";

if(empty($_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']){
	http_response_code(401);
	return;
}

try{
	Formation::removeformation($_POST['idFormation']);
	http_response_code(200);
}
catch (Exception $e){
	http_response_code(400);
}