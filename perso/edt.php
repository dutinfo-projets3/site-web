<?php
require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

$user = Utilisateur::createFromSession();

echo TwigLoader::getInstance()->render('', 'perso/edt', array("displayPanelButton" => false, "usertype" => $user->getUserType()));
