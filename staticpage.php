<?php
require_once("autoload.inc.php");

// On évite le remontage d'arborescence :)
if (!isset($_GET['page']) || empty($_GET['page']) || strpos($_GET["page"], "..") || strpos($_GET["page"], "/")){
	header('Location: /');
} else {
	$formations = null;
	if($_GET['page'] == "programme"){
		$formations = Formation::getFormations();
	}
	$html = "";

	try {
		$html = TwigLoader::getInstance()->render($_GET['page'], "static/" . $_GET['page'], array("formations" => $formations));
	} catch (Exception $e){
		header('Location: /');
	}

	echo $html;
}
