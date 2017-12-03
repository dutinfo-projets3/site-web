<?php

require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

$isme = false;

if (isset($_GET["user"]) && !empty($_GET["user"]) && Utilisateur::createFromSession()->getUserType() == Utilisateur::TYPES["ADMINISTRATION"]) {
	$user = Utilisateur::createFromID($_GET["user"]);
} else {
	$user = Utilisateur::createFromSession();
	$isme = true;
}

echo TwigLoader::getInstance()->render('', 'perso/infoperso', array("isme" => $isme, "user" => $user));
