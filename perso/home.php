<?php
require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}

echo "heyy";
