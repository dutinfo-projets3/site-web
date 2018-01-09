<?php
require_once 'lib/icalendar/zapcallib.php';
require_once 'autoload.inc.php';

// Création du calendrier
$calendar = new ZCiCal();

// Ouverture d'un fichier test.ics pour les test (mettre en commentaire a la fin des tests)
//$file = fopen("test.ics","w+");

// On récupere l'utilisateur
$user = Utilisateur::createFromSession();

// On récupere le type de l'utilisateur
$type = $user->getType();

// On récupere ses cours
$seances = array();

// Si l'utilisateur connecté est un étudiant, alors :
if($type == 0){
	// On récupere ses groupes
	$groupes = $user->getGroupes();
	
	foreach ($groupes as $g) {
		$temp = $g->getSeances();
		foreach($temp as $t){
			$seances[] = $t;
		}
	}
}else if($type == 1){
	$seances = $user->getSeances();
}

// On ajoute les evenements au calendrier
foreach($seances as $seance){
	// Creation d'un evenement
	$event = new ZCiCalNode("VEVENT", $calendar->curnode);
	// Ajout d'un titre a l'evenement
	$event->addNode(new ZCiCalDataNode("SUMMARY:" . $seance->getMatiere()->getNomMatiere()));
	// Ajout de la date de début
	$event->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($seance->getDateDebut())));
	// Ajout de la date de fin
	$event->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($seance->getDateFin())));
	// Ajout de l'item UID (unique pour chaque event, obligatoire)
	$event->addNode(new ZCiCalDataNode("UID:" . date('Y-m-d-H-i-s') . "@projets3.oxodao.fr"));
	// Ajout de l'item DTSTAMP (obligatoire)
	$event->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));
	

	$description =  "[Groupe] " . $seance->getGroupe()->getNomGroupe() . "\n";

	if($type == 0){
		$description .= "[Professeur] " . $seance->getProfesseur()->getNom() . " " . $seance->getProfesseur()->getPrenom() . "\n"; 
	}
					
	$description .= "[Salle] " . $seance->getSalle()->getFormatedSalle() . "\n" ;
	if($seance->getNotes() != NULL){
		$description .=	"[Notes] " . $seance->getNotes();
	}
	

	// Ajout de la description de la séance
	$event->addNode(new ZCiCalDataNode( "DESCRIPTION:" . $description));
}

// On ecrit dans le fichier test.ics (mettre en commentaire a la fin des tests)
//fwrite($file,$calendar->export());

// On ferme le fichier test.ics (mettre en commentaire a la fin des tests)
//fclose($file);

// On ecrit dans le flux de sortie le code du fichier .ics
echo $calendar->export();