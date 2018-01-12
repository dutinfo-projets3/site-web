<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 15/12/2017
 * Time: 14:49
 */
require_once "../autoload.inc.php";

if (empty($_GET['idNews'])
	&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION']) {
	http_response_code(400);
	return;
}

if (isset($_GET['idNews']) && !empty($_GET['idNews'])) {
	$news = News::createFromID($_GET['idNews']);
	$description = $news->getDescription();
	$title = $news->getNomEvenement();
	$res = array("title" => $title, "description" => ($description));

	header("Content-type: application/json");
	echo json_encode($res);
}



