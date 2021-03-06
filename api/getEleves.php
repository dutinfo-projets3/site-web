<?php
require_once "../autoload.inc.php";
require_once "verifAbsences.php";
$jour = $_GET['jour'];
$mois = $_GET['mois'];
$annee = $_GET['annee'];
$heureD = $_GET['dheure'];
$minuteD = $_GET['dminute'];

$secu = true;
$params = array($jour,$mois,$annee,$heureD,$minuteD);
foreach ($params as $value) {
	$secu = $secu && baseVerif($value);
}

if($secu && isValidDay($jour,$mois,$annee) && isValidHour($heureD,$minuteD)){
	$p = Utilisateur::createFromSession();

	$seance = $p->getSeance($annee, $mois, $jour, $heureD,$minuteD);
	if($seance == null){
		return;
	}

	$etudiants = $seance->getEleves();
	for($i=0;$i<count($etudiants);$i++){
		$etudiants[$i]['isAbsent'] = Absence::isAbsent($etudiants[$i]['id'],$seance->getIdSeance());
	}
	header("Content-type: application/json");
	echo json_encode($etudiants);
} else {
	http_response_code(400);
	return;
}