<?php
require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

$user = Utilisateur::createFromSession();

$forms = array();
$formations = array();

foreach ($user->getFormations() as $form){
	$formName = $form->getNomFormation();
	$formations[$formName] = $form->getIdFormation();
	$forms[$formName] = Annee::createFromUser($user->getID(), $form->getIdFormation());
}

echo TwigLoader::getInstance()->render('', 'perso/notes', array("user" => $user, "formations" => $formations, "annees" => $forms));
