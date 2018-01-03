<?php

require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

$isme = false;

$params = array();

$isAdmin = Utilisateur::createFromSession()->getUserType() == Utilisateur::TYPES["ADMINISTRATION"];

if ($isAdmin && isset($_GET["multiple"]) && !empty($_GET["multiple"])){
	$params["userList"] = Utilisateur::createList();
}

if (isset($_GET["user"]) && !empty($_GET["user"]) && $isAdmin) {
	$user = Utilisateur::createFromID($_GET["user"]);
} else {
	$user = Utilisateur::createFromSession();
	$isme = true;
}
$params["isme"] = $isme;
$params["user"] = $user;

echo TwigLoader::getInstance()->render('', 'perso/infoperso', $params);
