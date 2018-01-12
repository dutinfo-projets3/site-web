<?php
require_once("../lib/icalendar/zapcallib.php");
require_once '../autoload.inc.php';

$calendar = new ZCiCal();

if (!isset($_GET["user"]) || empty($_GET["user"])) {
	http_response_code(400);
	return;
}

$user = Utilisateur::createFromUsername($_GET["user"]);
$type = $user->getType();

$seances = array();
if ($type == 0) {
	$groupes = $user->getGroupes();

	foreach ($groupes as $g) {
		$temp = $g->getSeances();
		foreach ($temp as $t) {
			$seances[] = $t;
		}
	}
} else if ($type == 1) {
	$seances = $user->getSeances();
}

foreach ($seances as $seance) {
	$event = new ZCiCalNode("VEVENT", $calendar->curnode);
	$event->addNode(new ZCiCalDataNode("SUMMARY:" . $seance->getMatiere()->getNomMatiere()));
	$event->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($seance->getDateDebut())));
	$event->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($seance->getDateFin())));
	$event->addNode(new ZCiCalDataNode("UID:" . date('Y-m-d-H-i-s') . "@projets3.oxodao.fr"));
	$event->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

	$description = "[Groupe] " . $seance->getGroupe()->getNomGroupe() . "\n";

	if ($type == 0) {
		$description .= "[Professeur] " . $seance->getProfesseur()->getNom() . " " . $seance->getProfesseur()->getPrenom() . "\n";
	}

	$description .= "[Salle] " . $seance->getSalle()->getFormatedSalle() . "\n";
	if ($seance->getNotes() != NULL) {
		$description .= "[Notes] " . $seance->getNotes();
	}

	$event->addNode(new ZCiCalDataNode("DESCRIPTION:" . $description));
}

header('Content-Type: text/calandar');
echo $calendar->export();
