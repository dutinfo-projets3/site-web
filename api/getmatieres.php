<?php
/**
 * + * Created by PhpStorm.
 * + * User: leo
 * + * Date: 09/01/2018
 * + * Time: 12:21
 * + */
require_once "../autoload.inc.php";

if (empty($_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(400);
	return;
}
try {
	$matieres = Matiere::getMatiereFromFormation($_POST['idFormation']);
	$arrayMatieres = array();
	foreach ($matieres as $matiere) {
		array_push($arrayMatieres, $matiere->toArray());

	}
	header("Content-type: application/json");
	echo json_encode($arrayMatieres);
} catch (Exception $e) {
	http_response_code(400);
}