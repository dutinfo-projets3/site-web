<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("autoload.inc.php");

/**
 * @TODO: Charger la liste des news et passer le tableau au twig
 */

echo TwigLoader::getInstance()->render('index.html.twig', array());
