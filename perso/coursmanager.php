<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 13/01/2018
 * Time: 13:10
 */

require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}
$formation = Formation::getFormations();
$professeurs = Professeur::getProfesseur();
$salles = Salle::getSalle();
echo TwigLoader::getInstance()->render('', 'perso/editschedule', array( "professeurs" => $professeurs, "salles" => $salles, "formations" => $formation));