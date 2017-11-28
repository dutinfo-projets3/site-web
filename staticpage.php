<?php
require_once("autoload.inc.php");

if (!isset($_GET['page']) || empty($_GET['page'])){
	header('Location: /');
} else {
	$html = "";

	try {
		$html = TwigLoader::getInstance()->render($_GET['page'], "static/" . $_GET['page'], array());
	} catch (Exception $e){
		header('Location: /');
	}

	echo $html;
}
