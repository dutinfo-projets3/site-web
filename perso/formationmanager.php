<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 08/01/2018
 * Time: 19:29
 */
require_once("../autoload.inc.php");

if (!Utilisateur::isConnected()){
	header('Location: /');
	return;
}
$formations = Formation::getFormations();

echo TwigLoader::getInstance()->render('', 'perso/editformation', array('formations'=>$formations));