<?php
require_once "autoload.inc.php";

if (!isset($_GET["id"]) || empty($_GET["id"])){
	header("Location: /");
}

$news = News::createFromID($_GET["id"], false);
$user = Utilisateur::createFromID($news->getIdSecretaire());
echo TwigLoader::getInstance()->render('news', 'news', array('news' => $news, 'user' => $user));
