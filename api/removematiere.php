<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 10/01/2018
 * Time: 13:31
 */

require_once "../autoload.inc.php";

if(empty($_POST['idMatiere'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']){
	http_response_code(401);
	return;
}

try{
	Matiere::removeMatiere($_POST['idMatiere']);
	http_response_code(200);
}
catch (Exception $e){
	http_response_code(400);
}