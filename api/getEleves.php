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
			WHERE idProfesseur = :prof
			AND CONVERT(DATE_FORMAT(dateDebut,"%Y-%c-%d %H:%i:00"),CHAR(19)) = :deb
			AND CONVERT(DATE_FORMAT(dateFin,"%Y-%c-%d %H:%i:00"),CHAR(19))  = :fin )))
		ORDER BY nomPers, prenomPers
SQL
);
	$stmt->bindParam(':prof',$id);
	$begin = date('Y-m-d H:i:s',strtotime($annee.'-'.$mois.'-'.$jour.' '.$heureD.':'.$minuteD.':00'));
	$end = date('Y-m-d H:i:s',strtotime($annee.'-'.$mois.'-'.$jour.' '.$heureF.':'.$minuteF.':00'));
	$stmt->bindParam(':deb',$begin);
	$stmt->bindParam(':fin',$end);
	if(!$stmt->execute()){
		throw new Exception();
	}
	$stmt->setFetchMode(PDO::FETCH_CLASS,"Utilisateur");
	$temp = $stmt->fetchAll();
	$eleves = array();
	foreach ($temp as $key => $value) {
		$eleves = array($eleves,$value);
	}
	var_dump($temp);
	/*header("Content-type: application/json");
	echo json_encode($eleves);*/
} else {
	http_response_code(400);
	return;
}