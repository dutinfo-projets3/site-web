<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 03/01/2018
 * Time: 01:00
 */
require_once "../autoload.inc.php";

if (empty($_POST['idNews']) && empty($_POST['description']) && empty($_POST['title']
		&& !Utilisateur::isConnected() && Utilisateur::createFromSession()->getUserType() != Utilisateur::TYPES['ADMINISTRATION'])) {
	http_response_code(400);
	return;
}

$res = false;
try {
	$res = News::updateNews(($_POST['idNews']), ($_POST['title']), ($_POST['description']));
} catch (Exception $e) {
	http_response_code(400);
}
$res ? http_response_code(200) : http_response_code(400);


