<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("autoload.inc.php");

$currentPage = 1;
$MAX_PAGE_VIEW = 3;
$pageAmt = ceil(News::getCountNumbers() / $MAX_PAGE_VIEW);

$listNews = array();

if (isset($_GET['page']) && !empty($_GET['page'])) {
	$currentPage = $_GET['page'];
	try {
		$listNews = News::createNewsNext(($_GET['page'] - 1) * $MAX_PAGE_VIEW, $MAX_PAGE_VIEW);
	} catch (InvalidArgumentException $e) {
	    $currentPage = 1;
		$listNews = News::createNewsNext(0, $MAX_PAGE_VIEW);
	}
} else {
	$listNews = News::createNewsNext(0, $MAX_PAGE_VIEW);
}

/**
 * Rendu
 */
echo TwigLoader::getInstance()->render('news', 'index', array('news' => $listNews, 'pageAmt' => $pageAmt, 'currentPage' => $currentPage));