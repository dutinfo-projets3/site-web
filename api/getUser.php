<?php
	require_once("../autoload.inc.php");
	if (!isset($_GET["id"]) || empty($_GET["id"])){
		http_response_code(400);
		return;
	}

	header("Content-Type: application/json");
	echo json_encode(Utilisateur::createFromID($_GET["id"])->asArray());
