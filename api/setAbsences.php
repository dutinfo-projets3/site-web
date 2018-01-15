<?php
require_once "../autoload.inc.php";
require_once "verifAbsences.php";

$jour = $_GET['jour'];
$mois = $_GET['mois'];
$annee = $_GET['annee'];
$heureD = $_GET['dheure'];
$minuteD = $_GET['dminute'];
$absents = $_GET['absents'];

if(isset($_GET['absents'])){
	$secu = true;
	$params = array($jour,$mois,$annee,$heureD,$minuteD);
	$absentIds = explode("+",$absents);
	$presentIds = array();
	if(!empty($_GET['absents'])){
		foreach ($absentIds as $misterNotHere) {
			array_push($params, $misterNotHere);
		}
	} else {
		// Le prof a fait l'appel et il n'y aucun absent
	}
	foreach ($params as $value) {
		$secu = $secu && baseVerif($value);
	}
	if($secu && isValidHour($heureD,$minuteD) && isValidDay($jour,$mois,$annee)){
		$p = Utilisateur::createFromSession();

		$seance = $p->getSeance($annee, $mois, $jour, $heureD,$minuteD);

		foreach ($absentIds as $id) {
			Absence::putIntoBd($id,$seance->getIdseance());
		}
	} else {
		http_response_code(400);
		return;
	}
}