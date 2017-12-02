<?php

require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

//$user = Utilisateur::createFromSession();
$user = Utilisateur::createFromID(3);

echo TwigLoader::getInstance()->render('', 'perso/infoperso', array("user" => $user));
