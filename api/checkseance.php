<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 14/01/2018
 * Time: 18:56
 */
require_once("../autoload.inc.php");
if (!Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(401);
	return;
}

if (!empty($_POST['idGroupe']) && !empty($_POST['dateDebut']) && !empty($_POST['dateFin'])) {
	$seances = Seance::getDateFromGroupe($_POST['idGroupe']);
	foreach ($seances as $seance) {

		$dateDebutBD = strtotime($seance["dateDebut"]);
		$dateFinBD = strtotime($seance["dateFin"]);
		$dateFin = strtotime($_POST['dateFin']);
		$dateDebut = strtotime($_POST['dateDebut']);
		if ((($dateDebutBD > $dateDebut && $dateDebutBD < $dateFin) || ($dateFinBD > $dateDebut && $dateFinBD < $dateFin)) || ($dateFinBD == $dateFin && $dateDebutBD == $dateDebut)
		|| (($dateDebut > $dateDebutBD && $dateDebut < $dateFinBD) || ($dateFin > $dateDebutBD && $dateFin < $dateFinBD)) ) {
			http_response_code(400);
		}

	}
}

if (!empty($_POST['idProfesseur']) && !empty($_POST['dateDebut']) && !empty($_POST['dateFin'])) {
	$seances = Seance::getDateFromProfesseur($_POST['idProfesseur']);
	foreach ($seances as $seance) {

		$dateDebutBD = strtotime($seance["dateDebut"]);
		$dateFinBD = strtotime($seance["dateFin"]);
		$dateFin = strtotime($_POST['dateFin']);
		$dateDebut = strtotime($_POST['dateDebut']);
		if (($dateDebutBD > $dateDebut && $dateDebutBD < $dateFin) || ($dateFinBD > $dateDebut && $dateFinBD < $dateFin) || ($dateFinBD == $dateFin && $dateDebutBD == $dateDebut)
			|| (($dateDebut > $dateDebutBD && $dateDebut < $dateFinBD) || ($dateFin > $dateDebutBD && $dateFin < $dateFinBD)) ) {
			http_response_code(400);
		}
	}

}

if (!empty($_POST['idSalle']) && !empty($_POST['dateDebut']) && !empty($_POST['dateFin'])) {
	$seances = Seance::getDateFromSalle($_POST['idSalle']);
	foreach ($seances as $seance) {

		$dateDebutBD = strtotime($seance["dateDebut"]);
		$dateFinBD = strtotime($seance["dateFin"]);
		$dateFin = strtotime($_POST['dateFin']);
		$dateDebut = strtotime($_POST['dateDebut']);
		if (($dateDebutBD > $dateDebut && $dateDebutBD < $dateFin) || ($dateFinBD > $dateDebut && $dateFinBD < $dateFin) || ($dateFinBD == $dateFin && $dateDebutBD == $dateDebut)
			|| (($dateDebut > $dateDebutBD && $dateDebut < $dateFinBD) || ($dateFin > $dateDebutBD && $dateFin < $dateFinBD)) ) {
			http_response_code(400);

		}
	}
}

