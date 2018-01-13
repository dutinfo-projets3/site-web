<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 13/01/2018
 * Time: 16:42
 */
require_once "../autoload.inc.php";
if (empty($_POST['idFormation'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(401);
	return;
}

try {
	$groupes = Groupe::getGroupeFromFormation($_POST['idFormation']);
	$matieres = Matiere::getMatiereFromFormation($_POST['idFormation']);
	$matiereSend = array();
	$groupesSend = array();
	foreach ($groupes as $groupe) {
		array_push($groupesSend, $groupe->toArray());
	}

	foreach($matieres as $matiere){
		array_push($matiereSend, $matiere->toArray());
	}

	header("Content-type: application/json");
	echo json_encode(array("matieres" => $matiereSend, "groupes" => $groupesSend));
}catch (Exception $e){
	http_response_code(400);
}