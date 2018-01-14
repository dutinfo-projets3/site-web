<?php
require_once "../autoload.inc.php";
$jour = $_GET['jour'];
$mois = $_GET['mois'];
$annee = $_GET['annee'];
$heureD = $_GET['dheure'];
$minuteD = $_GET['dminute'];
$heureF = $_GET['fheure'];
$minuteF = $_GET['fminute'];

$p = Utilisateur::createFromSession();

$seance = $p->getSeance($annee, $mois, $jour, $heureD,$minuteD, $heureF, $minuteF);

$etudiants = $seance->getEleves();

header("Content-type: application/json");
echo json_encode($etudiants);