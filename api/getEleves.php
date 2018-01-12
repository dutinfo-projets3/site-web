<?php
require_once "../autoload.inc.php";
require_once 'verifAbsences.php';

$id = $_GET['idUser'];
$jour = $_GET['jour'];
$mois = $_GET['mois'];
$annee = $_GET['annee'];
$heureD = $_GET['dheure'];
$minuteD = $_GET['dminute'];
$heureF = $_GET['fheure'];
$minuteF = $_GET['fminute'];
if(baseVerif($id) && baseVerif($jour) && baseVerif($mois) && baseVerif($annee) &&
	baseVerif($heureD) && baseVerif($heureF) && baseVerif($minuteF) && baseVerif($minuteD) && isValidDay($jour,$mois,$annee) && coherence($heureD,$minuteD,$heureF,$minuteF)){
	$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT *
		FROM Utilisateur
		WHERE idPersonne IN (SELECT idEtudiant
							 FROM Etudiant
							 WHERE idEtudiant IN ( SELECT idEtudiant
							 						FROM Appartient
							 						WHERE idGroupe
		IN (SELECT idGroupe
			FROM Seance
			WHERE idProfesseur = ?
			AND dateDebut = ?
			AND dateFin  = ? )))
		ORDER BY nomPers, prenomPers
SQL
);
	$begin = $annee.'-'.$mois.'-'.$jour.' '.$heureD.':'.$minuteD.':00';
	//echo $begin."\n";
	$end = $annee.'-'.$mois.'-'.$jour.' '.$heureF.':'.$minuteF.':00';
	//echo $end."\n";
	if(!$stmt->execute(array($id,$begin,$end))){
		throw new Exception();
	}
	$stmt->setFetchMode(PDO::FETCH_CLASS,"Utilisateur");
	$eleves  = $stmt->fetchAll();
	$sendEleves = array();
	foreach ($eleves as $eleve) {
		array_push($sendEleves, array("nom" =>$eleve->getNom(),"id" => $eleve->getID(), "prenom" => $eleve->getPrenom()));
	}
	header("Content-type: application/json");
	echo json_encode($sendEleves);
} else {
	http_response_code(400);
	return;
}