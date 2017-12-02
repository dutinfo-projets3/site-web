<?php
require_once "autoload.inc.php";

if (!isset($_GET["id"]) || empty($_GET["id"])){
	header("Location: /");
}

$news = News::createFromID($_GET["id"], 1);

echo TwigLoader::getInstance()->render('news', 'news', array('news' => $news));
