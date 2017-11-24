<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("autoload.inc.php");

/**
 * @TODO: Charger la liste des news et passer le tableau au twig
 */
$MAX_PAGE_VIEW = 2;
$listNews = Array();
$numberOfPage = ceil(News::getCountNumbers() / $MAX_PAGE_VIEW);

if (isset($_GET['pageNumber']) && !empty($_GET['pageNumber'])) {
    $currentlyPage = $_GET['pageNumber'];
    $star = (($_GET['pageNumber'] - 1) * $MAX_PAGE_VIEW);
    $listNews = News::createNewsNext($star, $MAX_PAGE_VIEW);

} else {
    $currentlyPage = 1;
    $listNews = News::createNewsNext(0, $MAX_PAGE_VIEW);

}

/**
 * Rendu
 */
echo TwigLoader::getInstance()->render('news', 'index', array('news' => $listNews, 'numberOfPage' => $numberOfPage, 'currentlyPage' => $currentlyPage));
