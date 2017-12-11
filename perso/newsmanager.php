<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 07/12/2017
 * Time: 11:39
 */

require_once("../autoload.inc.php");

try {
	$user = Utilisateur::createFromSession();
}catch (Exception $e){
	header('Location: /');
}
if (!Utilisateur::isConnected() || !$user->getUserType() == Utilisateur::TYPES['ADMINISTRATION']){
	header('Location: /');
	return;
}
$success = false;
if(isset($_POST["titre"]) && isset($_POST["description"])){
	try {
		$success = News::insertIntoBD($user->getID(), $_POST["titre"], $_POST["description"]);
	}
	catch(Exception $e){

	}

}

echo TwigLoader::getInstance()->render('', 'perso/editnew', array('success' => $success));