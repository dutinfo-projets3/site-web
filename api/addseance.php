<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 13/01/2018
 * Time: 18:35
 */

require_once "../autoload.inc.php";

if (empty($_POST['idSalle']) && empty($_POST['idMatiere']) && empty($_POST['idGroupe']) && empty($_POST['idProfesseur']) && empty($_POST['dateDeb']) && empty($_POST['dateFin'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(401);
	return;
}

Seance::addSeance($_POST['idSalle'], $_POST['idMatiere'], $_POST['idGroupe'], $_POST['idProfesseur'], $_POST['dateDeb'], $_POST['dateFin']);